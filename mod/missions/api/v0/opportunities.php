<?php

  require_once(elgg_get_plugins_path() . 'missions/api/v0/api.php');
  mm_api_secure();

  list($oppor_guids, $fields) = mm_api_get_entity_guids('object', 'mission', $segments[3]);
  $oppor_total = count($oppor_guids);

  echo "{\"opportunities\":[";
  flush();

  $export = mm_api_entity_export($oppor_guids, $fields, $oppor_total);
  foreach ($export as $data) {
    $row = json_encode($data[0]) . (($data[1]) ? ",\n" : "\n");
    echo $row;
    flush();
  }
  echo "]}";
  exit;
?>