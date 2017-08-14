<?php

$widget = $vars["entity"];
$height = sanitise_int($widget->height, false);

if (!$height) $height = 300;
if (!$widget->embed_url) $height = 50;
?>

<div style='height:<?php echo $height; ?>px; overflow:scroll;'>

<?php echo (!$widget->embed_url) ? elgg_echo('widgets:twitter_search:not_configured') : $widget->embed_url;	?>

</div>

