<?php

  require_once(elgg_get_plugins_path() . 'missions/api/v0/api.php');
  mm_api_secure();

  list($user_guids, $fields) = mm_api_get_entity_guids('user', false, $segments[3]);
  $user_total = count($user_guids);

  echo "{\"users\":[";
  flush();
  $export = mm_api_entity_export($user_guids, $fields, $user_total);
  foreach ($export as $data) {
    $row = json_encode($data[0]) . (($data[1]) ? ",\n" : "\n");
    echo $row;
    flush();
  }
  echo "]}";
  exit;
?>