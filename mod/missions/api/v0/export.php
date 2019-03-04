<?php
  namespace NRC;

  if (isset($_GET['debug'])) {
    opcache_reset();
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
  }
  require_once(elgg_get_plugins_path() . 'missions/api/v0/api.php');

  class export {

    public static $version = 'v0.0.3';
    public static $help = <<<EOD
<!DOCTYPE html>
<html>
  <body>
    <H1>
      NRC Recommendation Provider API
      <sub style="font-size: 0.5em">::version::</sub>
    </H1>
    <p>
      This API provides the means by which recommendation services can collect
      GCConnex data.  A private key is required to access this service.
    </p>
    <H3>Endpoints</H3>
    <ul>
      <li>
        <h4>/missions/api/v0/export[/guid]</h4>
        <p>
          Used to export any entity.  If a guid is provided, only that entity
          is returned.
        </p>
        Examples:
        <ul>
          <li>/missions/api/v0/export</li>
          <li>/missions/api/v0/export/205</li>
          <li>/missions/api/v0/export/42922688</li>
          <li>/missions/api/v0/export?since=1539475200&limit=2</li>
        </ul>
      </li>
      <li>
        <h4>/missions/api/v0/user[/guid]</h4>
        <p>
          Used to export users.  If a guid is provided, only that user is
          returned.
        </p>
        Examples:
        <ul>
          <li>/missions/api/v0/user</li>
          <li>/missions/api/v0/user/205</li>
          <li>/missions/api/v0/user?since=1539475200</li>
        </ul>
      </li>
      <li>
        <h4>
          /missions/api/v0/object[/guid]<br>
          /missions/api/v0/object/subtype[/guid]
        </h4>
        <p>
          Used to export objects.  If a guid is provided, only that object is
          returned.  A subtype can also be specified.
        </p>
        Examples:
        <ul>
          <li>/missions/api/v0/object</li>
          <li>/missions/api/v0/object/42922688</li>
          <li>/missions/api/v0/object?since=1539475200&limit=1</li>
          <li>/missions/api/v0/object/widget?since=1539475200</li>
        </ul>
      </li>
    </ul>
    <H3>Query parameters</H3>
    <p>Parameters can be used to perform more complex queries.</p>
    <table>
      <thead>
        <tr>
          <th>Parameter</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>before</td>
          <td>
            Fetch entities that have been modified before the specified time.
            Expects a unix timetamp.
          </td>
        </tr>
        <tr>
          <td>since</td>
          <td>
            Fetch entities that have been modified after the specified time.
            Expects a unix timetamp.
          </td>
        </tr>
        <tr>
          <td>limit</td>
          <td>
            Limits the number of returned entities.  Expects an positive
            integer.
          </td>
        </tr>
        <tr>
          <td>resume</td>
          <td>
            Resume starting at the specified GUID.  Expects a valid GUID.
          </td>
        </tr>
        <tr>
          <td>sort</td>
          <td>
            If specified sorts returned entities by created time - By default
            rows are returned in natural order without any sorting guarantees.
            This parameter doesn't take any value, its presence enables
            sorting.
          </td>
        </tr>
        <tr>
          <td>omit</td>
          <td>
            List of GUIDs to omit from the results.  Useful to omit large
            objects we know we are not interested in.  For example GUID "1".
            Takes a comma separated list of GUIDs.
          </td>
        </tr>
        <tr>
          <td>count</td>
          <td>
            Include the total number of entities that match the search
            criteria.  (Executes a separate query on the server to count)
          </td>
        </tr>
        <tr>
          <td>version<strong>*<strong></td>
          <td>
            Returns the API version as a JSON object and exits.  No query is
            performed regardless of other parameters.
          </td>
        </tr>
        <tr>
          <td>help<strong>*<strong></td>
          <td>
            Returns the API help text as an HTML page and exits.  No query is
            performed regardless of other parameters.
          </td>
        </tr>
      </table>
      <small><strong>*<strong> These parameters do not require a private key</small>
      <H3>Returns</H3>
      Successful queries return JSON objects like this:
      <pre>
      {
        "query": {
            "object_type": "export",     // type of export
            "api_version": "v0.0.3",     // current API version
            "subtype": false,            // requested subtype, if specified
            "guid": null,                // requested GUID, if specified
            "since": "1539475200",       // "since" parameter, if specified
            "before": null,              // "before" parameter, if specified
            "limit": null,               // "limit" parameter, if specified
            "request_time": 1546958611,  // server's current unix timestamp
            "count": 14                  // Total number of matched entities
        },
        "export": [ ... ]                // Array of requested entities
      }
      </pre>
  </body>
</html>
EOD;

    private $object_type = false;
    private $subtype = false;
    private $guid = null;
    private $since = null;
    private $before = null;
    private $limit = null;
    private $omit = null;

    static function getHelp() {
      return str_replace('::version::', self::$version, self::$help);
    }

    function __construct($object_type, $subtype = false, $guid = null,
      $since = null, $before = null, $limit = null, $resume = null,
      $sort = false, $omit = null, $count = false) {

      mm_api_secure();

      $this->object_type = $object_type;
      $this->subtype = $subtype;
      $this->guid = $guid;
      $this->since = $since;
      $this->before = $before;
      $this->limit = $limit;
      $this->resume = $resume;
      $this->sort = $sort;
      $this->omit = $omit;
      $this->count = $count;
    }

    public static function getQueryCount() {
      $queries_result = mysql_query(
        'show session status like "Queries";',
        _elgg_services()->db->getLink('read')
      );
      $r = mysql_fetch_object($queries_result);
      $queries = $r->Value;
      mysql_free_result($queries_result);
      return intval($queries) - 1;
    }

    /**
     * Stream the export results using JSON format
     */
    function outputJSON() {
      while (@ob_end_flush());

      $queryCount = self::getQueryCount();
      $exporter = mm_api_export_entities(
        $this->object_type,
        $this->subtype,
        $this->guid,
        $this->since,
        $this->before,
        $this->limit,
        $this->resume,
        $this->sort,
        $this->omit,
        $this->count
      );
      $queryData = [
        'object_type' => $this->object_type,
        'api_version' => self::$version,
        'subtype' => $this->subtype,
        'guid' => $this->guid,
        'since' => $this->since,
        'before' => $this->before,
        'limit' => $this->limit,
        'request_time' => time(),
      ];
      if ($this->count) {
        $queryData['count'] = $exporter->current();
      }
      echo '{"query":' .json_encode($queryData). ',"export":[';
      flush();
      $exporter->next();

      // ignore the first comma
      $exporter->next();

      while ($exporter->valid()) {
        $output = $exporter->current();
        echo $output;
        flush();
        ob_flush();
        $exporter->next();
      }
      $queryCount = self::getQueryCount() - $queryCount - 2;
      echo "], \"queryCount\": $queryCount}\r\n";
      exit;
    }
  }
?>
