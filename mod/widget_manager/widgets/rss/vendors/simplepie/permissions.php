<?php

  // Load Elgg engine
  require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php");

  ob_start();
  
?>

<style type="text/css">
#permissions {
  margin:20px 0 0 0;
  font:14px/1.4em "Lucida Grande", Verdana, Arial, Helvetica, Clean, Sans, sans-serif;
  letter-spacing:0px;
  color:#333;
}
</style>

<div style="margin:0; min-height:340px;">

<div id="elggreturn">
  <a href="javascript:history.go(-1)">Return to Tools Administration</a>
</div>
<div id="permissions">

<?php
  
  if (is_writable('cache'))
    echo '<p>Good news. The cache directory is writeable.</p>';
  else
    echo '<p>The cache directory is not writeable.</p>';
    
  echo '<p>The permissions on the directory are ' . substr(decoct(fileperms('cache')),2) . '.</p>';
  
?>
</div>
</div>

<?php  
  $content = ob_get_clean();
  $body = elgg_view_layout('one_column', $content);
  echo page_draw(null, $body);