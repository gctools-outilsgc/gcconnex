<?php

$options = elgg_extract('options', $vars, array());

if(empty($options)) {
    return true;
}
?>

<div class="checklist">
<?php foreach($options as $_ => $params) { ?>
    <div class="checklist-item">
	<?php
        echo elgg_view('phloor/input/vendors/prettycheckboxes/enable', $params);
    ?>
	</div>
<?php } ?>
</div>
<div style="clear: both;"></div>

<?php
