<?php
/**
* Enhanced User Search
* Copyright (c) 2017 National Research Council Canada
* @author Luc Belliveau <luc.belliveau@nrc-cnrc.gc.ca>
*
* This library provides enhanced search functionality to enable rapid search
* using the native elgg database.
*
* The module could also be used as an abstraction to other search providers
* in the future such as SOLR, Elasticsearch, etc.
*
*/

namespace NRC\EUS;

require_once("sql.php");

/**
* Generic Search interface
*/
interface iMemberSearch {

  public function initialize();
  public function refresh();
  public function search($term, $limit);

}

/**
* Database driven implementation of the generic search interface
*/
class DatabaseSearch implements iMemberSearch {
  function __construct() {
    global $CONFIG;

    $c = new SQL\Constants();
    list(
      $this->tableName,
      $this->procName,
      $this->BUILD_SQL,
      $this->INDEX_SQL,
      $this->REFRESH_PROC,
      $this->SEARCH_SQL
    ) = $c->get();

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

  function __destruct() {
    mysqli_close($this->conn);
  }

  public function initialize() {

    $check_query = "SELECT *
      FROM
        information_schema.tables
      WHERE
        table_schema = '{$this->db_name}'
        AND table_name = '{$this->tableName}'
      LIMIT 1";

    $result = mysqli_query($this->conn, $check_query);
    if ($result->num_rows === 0) {
      mysqli_query($this->conn, $this->BUILD_SQL);
      mysqli_query($this->conn, $this->INDEX_SQL);
      mysqli_query($this->conn, $this->REFRESH_PROC);
      $this->refresh();
    }
    mysqli_free_result($result);
  }

  public function refresh() {
    mysqli_query($this->conn, "CALL `{$this->procName}`();");
  }

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

function get() {
  // we could allow configuration of backends here
  return new DatabaseSearch();
}


