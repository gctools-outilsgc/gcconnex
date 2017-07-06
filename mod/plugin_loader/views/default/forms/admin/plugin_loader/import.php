<?php

echo '<p style="margin-top:20px">'.elgg_echo('plugin_loader:import_instructions').'</p>';
echo elgg_view(
  'input/submit',
  array(
    'value' => elgg_echo('plugin_loader:import'),
    'id' => 'pluginLoaderImportBtn'
  )
);

?>
