<?php
/**
 * Elgg pages widget edit
 *
 * @package ElggPages
 */

// set default value
if (!isset($vars['entity']->pages_num)) {
	$vars['entity']->pages_num = 4;
}

$params = array(
	'name' => 'params[pages_num]',
	'value' => $vars['entity']->pages_num,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
    'id' => 'pages-params[pages_num]',
);
$dropdown = elgg_view('input/select', $params);

?>
<div>
    <?php echo '<label for="pages-params[pages_num]">'.elgg_echo('pages:num').'</label>'; ?>:
	<?php echo $dropdown; ?>
</div>
