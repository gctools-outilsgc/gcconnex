<?php
  namespace NRC;

  require_once(elgg_get_plugins_path() . 'missions/api/v0/api.php');
  mm_api_secure();

  class export {

    private $object_type = false;
    private $subtype = false;
    private $guid = null;
    private $since = null;
    private $before = null;
    private $limit = null;

    function __construct($object_type, $subtype = false, $guid = null,
      $since = null, $before = null, $limit = null, $resume = null,
      $sort = false) {
      $this->object_type = $object_type;
      $this->subtype = $subtype;
      $this->guid = $guid;
      $this->since = $since;
      $this->before = $before;
      $this->limit = $limit;
      $this->resume = $resume;
      $this->sort = $sort;
    }

    function getJSON() {
      while (@ob_end_flush());
      $guids = mm_api_get_entity_guids(
        $this->object_type,
        $this->subtype,
        $this->guid,
        $this->since,
        $this->before,
        $this->limit,
        $this->resume,
        $this->sort
      );
      echo "{\"export\": [\n";
      $chunk_header = [ 'header' => [
        'object_type' => $this->object_type,
        'subtype' => $this->subtype,
        'guid' => $this->guid,
        'since' => $this->since,
        'before' => $this->before,
        'limit' => $this->limit,
        'request_time' => time(),
        'count' => $guids->current()
      ]];
      echo json_encode($chunk_header) . "\n";
      flush();

      $export = mm_api_entity_export($guids);
      foreach ($export as $output) {
        // $export[$object->getType()][$object->getSubtype()][] = $data;
        echo ",\n" . json_encode($output['export']) . "\n";
        // $row = json_encode($data[0]) . (($data[1]) ? ",\n" : "\n");
        // echo $row;
        flush();
        ob_flush();
      }
      echo "]}\r\n";

      exit;
    }
  }
?>
