<?php

$options = elgg_extract('options', $vars, array());

if(empty($options)) {
    return true;
}
?>

<ul class="checklist">
<?php foreach($options as $_ => $params) { ?>
    <li class="checklist-item">
	<?php
        echo elgg_view('phloor/input/vendors/prettycheckboxes/enable', $params);
    ?>
	</li>
<?php } ?>
</ul>
<div style="clear: both;"></div>

<?php
