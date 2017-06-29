<?php
  namespace NRC;

  require_once(elgg_get_plugins_path() . 'missions/api/v0/api.php');
  mm_api_secure();

  class export {

    private $object_type = false;
    private $subtype = false;
    private $guid = null;

    function __construct($object_type, $subtype = false, $guid = null) {
      $this->object_type = $object_type;
      $this->subtype = $subtype;
      $this->guid = $guid;
    }

    function getJSON() {
      list($oppor_guids, $fields) = mm_api_get_entity_guids(
        $this->object_type,
        $this->subtype,
        $this->guid
      );

      $oppor_total = count($oppor_guids);

      $dictionary_name = ($this->subtype) ? $this->subtype : $this->object_type;

      echo "{\"{$dictionary_name}\":[";
      flush();

      $export = mm_api_entity_export($oppor_guids, $fields, $oppor_total);
      foreach ($export as $data) {
        $row = json_encode($data[0]) . (($data[1]) ? ",\n" : "\n");
        echo $row;
        flush();
      }
      echo "]}";

      exit;
    }
  }

  class subtypeExport  {
    function getJSON() {
      $subtypes = mm_api_get_subtypes();
      $simple = array();
      foreach ($subtypes as $st) {
        $simple[] = $st->subtype;
      }
      echo json_encode($simple);
      exit;
    }
  }
?>
