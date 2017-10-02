<?php
$mode = get_input('mode');
if($mode == 'embed'){

  echo '<ul class="elgg-tabs"><li><a href="freshdesk_help?mode=default">Main</a></li><li class="elgg-state-selected active"><a href="freshdesk_help?mode=embed">GCpedia Widget</a></li></ul>';
  $portal = 2100008990;
  $action = 'pedia-save.php';

} else {

echo '<ul class="elgg-tabs"><li class="elgg-state-selected active"><a href="freshdesk_help?mode=default">Main</a></li><li><a href="freshdesk_help?mode=embed">GCpedia Widget</a></li></ul>';
$action = 'save.php';

//old user account
$params = array(
        'name' => 'params[apikey]',
        'id' => 'apikey',
        'class' => 'mrgn-bttm-sm',
        'value' => $vars['entity']->apikey,
    );

echo '<div class="basic-profile-field">';
echo '<label for="apikey">API key</label>';
echo elgg_view("input/text", $params);
echo '</div>';

//new user account
$params = array(
        'name' => 'params[apikey]',
        'id' => 'apikey',
        'class' => 'mrgn-bttm-sm',
        'value' => $vars['entity']->apikey,
    );

echo '<div class="basic-profile-field">';
echo '<label for="apikey">API key</label>';
echo elgg_view("input/text", $params);
echo '</div>';
?>
<style>
  select {
    font: 120% Arial, Helvetica, sans-serif;
    padding: 5px;
    border: 1px solid #ccc;
    color: #666;
    border-radius: 5px;
    margin: 0;
    width: 98%;
  }

  .article-button {
    padding: 8px 16px;
    border: 2px solid black;
    border-radius: 3px;
  }

  .article-button:hover {
    background: #eee;
  }

  .article-message {
    margin: 15px;
  }
</style>
