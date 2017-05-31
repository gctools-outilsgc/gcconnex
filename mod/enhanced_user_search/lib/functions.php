<?php
/**
* Enhanced User Search
* Copyright (c) 2017 National Research Council Canada
* @author Luc Belliveau <luc.belliveau@nrc-cnrc.gc.ca>
*
* This library provides enhanced search functionality to enable rapid search
* using the native elgg database or other backends.
*
*/

namespace NRC\EUS;

/**
 * Generic Search interface.
 *
 * To implement a new backend, simply implement this interface.
 */
interface iMemberSearch {

  /**
   * Executes if required any specialized initialization routines required
   * for the backend.
   *
   * @return void
   */
  public function initialize();

  /**
   * Updates the backend if required with system data.
   *
   * @return void
   */
  public function refresh();

  /**
   * Executes a search.
   *
   * @param string term   Search term
   * @param int    limit  Maximum number of results to return
   * @param int    offset Begin returning results starting from offset
   *
   * @return array Query result set
   *               array(
   *                 term              string Search term used to generate
   *                 execution_time    int    Time to execute in Ms
   *                 total             int    Total number of matching users
   *                 start             int    Position offset
   *                 rows              int    Number of returned users
   *                 users             array
   *                   user_guid       int    GUID of user
   *                   name            string Name of user
   *                   relevance       int    Relevance (higher is better)
   *                   contactemail    string Email address
   *                   education       string Education
   *                   gc_skills       string Comma separated list of skills
   *                   portfolio       string Portfolio
   *                   work            string Work
   *                   matched_using   array  Array of 0 for false, 1 for true
   *                     name          int    `name` was used to match
   *                     contactemail  int    `contactemail` was used to match
   *                     education     int    `education` was used to match
   *                     gc_skills     int    `gc_skills` was used to match
   *                     portfolio     int    `portfolio` was used to match
   *                     work          int    `work` was used to match
   *                   )
   *                 )
   */
  public function search($term, $limit, $offset);

  /**
  * Determines if the class is ready for queries.
  *
  * @return boolean
  */
  public function isReady();

}

/**
* Database driven implementation of the generic search interface
*/
class DatabaseSearch implements iMemberSearch {
  /**
   * DatabaseSearch constructor creates a connection to the database and loads
   * required SQL constants.
   *
   */
  function __construct() {
    global $CONFIG;

    // Load SQL constants
    require_once("sql.php");
    $c = new SQL\Constants();
    list(
      $this->tableName,
      $this->procName,
      $this->BUILD_SQL,
      $this->INDEX_SQL,
      $this->REFRESH_PROC,
      $this->SEARCH_SQL,
      $this->READY_SQL,
      $this->TABLE_EXISTS_SQL,
      $this->PROC_EXISTS_SQL
    ) = $c->get();

    // Establish a connection to the database.
    $db_config = new \Elgg\Database\Config($CONFIG);
    $read_settings = $db_config->getConnectionConfig(
      ($db_config->isDatabaseSplit()) ?
        \Elgg\Database\Config::WRITE :
        \Elgg\Database\Config::READ_WRITE
    );

    $this->db_name = $read_settings["database"];

    $this->conn = mysqli_connect(
      $read_settings["host"],
      $read_settings["user"],
      $read_settings["password"],
      $read_settings["database"]
    );
    if (mysqli_connect_errno($this->conn))
      elgg_log("Failed to connect: ".mysqli_connect_errno(), 'NOTICE');

  }

  /**
   * DatabaseSearch destructor closes the open connection to the database.
   *
   * @return void
   */
  function __destruct() {
    mysqli_close($this->conn);
  }

  /**
   * Creates the required tables and stored procedures if they do not exist.
   *
   * @return void
   */
  public function initialize() {
    $result = mysqli_query($this->conn, $this->TABLE_EXISTS_SQL);
    if ($result->num_rows === 0) {
      mysqli_multi_query($this->conn, $this->BUILD_SQL);
      while (mysqli_next_result($this->conn)) {;}
      mysqli_multi_query($this->conn, $this->INDEX_SQL);
      while (mysqli_next_result($this->conn)) {;}
    }
    mysqli_free_result($result);

    $result = mysqli_query($this->conn, $this->PROC_EXISTS_SQL);
    if ($result->num_rows === 0) {
      mysqli_query($this->conn, $this->REFRESH_PROC);
    }
    mysqli_free_result($result);
  }

  public function isReady() {
    $result = mysqli_query($this->conn, $this->READY_SQL);
    $ready = $result->num_rows === 1;
    mysqli_free_result($result);
    return $ready;
  }

  public function refresh() {
    set_time_limit(500);
    mysqli_query($this->conn, "CALL `{$this->procName}`();");
  }

  /**
   * Returns true if the specified term is found in the haystack.
   * The term is split by spaces and each term is individually searched for in
   * the haystack to mimic MySQL's fulltext search.
   *
   * @param string haystack String to search in
   * @param string term     String to search for in haystack
   * @return boolean
   */
  private function isMatched($haystack, $term) {
    $terms = split(' ', strtolower(trim($term)));
    $h = strtolower($haystack);

    foreach ($terms as $t) {
      if (strpos($h, $t) !== false) {
        return true;
      }
    }
    return false;
  }

  public function search($term, $limit=10, $offset=0) {
    $start_time = time();
    $p = mysqli_prepare($this->conn, $this->SEARCH_SQL);
    $lterm = strtolower(trim($term));
    if (strpos($lterm, '*') === strlen($lterm)-1) {
      $lterm = substr($lterm, 0, strlen($lterm)-1);
    }

    $p->bind_param('ssii', $term, $term, $offset, $limit);
    $p->execute();
    $p->bind_result(
      $user_guid,
      $name,
      $relevance,
      $contactemail,
      $education,
      $gc_skills,
      $portfolio,
      $work
    );

    $users = [];
    while ($p->fetch()) {

      $users[] = array(
        'user_guid' => $user_guid,
        'name' => $name,
        'relevance' => $relevance,
        'contactemail' => $contactemail,
        'education' => $education,
        'gc_skills' => $gc_skills,
        'portfolio' => $portfolio,
        'work' => $work,
        'matched_using' => array(
          'name' => $this->isMatched($name, $lterm),
          'contactemail' => $this->isMatched($contactemail, $lterm),
          'education' => $this->isMatched($education, $lterm),
          'gc_skills' => $this->isMatched($gc_skills, $lterm),
          'portfolio' => $this->isMatched($portfolio, $lterm),
          'work' => $this->isMatched($work, $lterm)
        )
      );
    }

    $total = mysqli_query($this->conn, 'SELECT FOUND_ROWS() as total_users');
    $r = $total->fetch_row();
    $total_users = $r[0];
    mysqli_free_result($total);
    $p->close();
    return array(
      'term' => $term,
      'execution_time' => $start_time - time(),
      'total' => $total_users,
      'start' => $offset,
      'rows' => count($users),
      'users' => $users
    );
  }
}

/**
 * The get method returns the configured backend search interface.
 *
 * @todo No configuration exists yet as only 1 backend has been created.
 * @return iMemberSearch
 */
function get() {
  return new DatabaseSearch();
}

/**
* The ready method calls the isReady method of the configured backend.
*
* @return boolean
*/
function ready() {
  return get()->isReady();
}


