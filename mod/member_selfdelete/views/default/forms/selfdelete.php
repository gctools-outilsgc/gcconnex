<?php

namespace Beck24\MemberSelfDelete;

$explanation = elgg_echo('member_selfdelete:explain:' . elgg_get_plugin_setting('method', PLUGIN_ID));
echo elgg_view('output/longtext', array(
	'value' => $explanation
));


if (elgg_get_plugin_setting('method', PLUGIN_ID) == "choose") {
	$value = elgg_get_sticky_value('member_selfdelete', 'method', 'delete');
	$options = array(
		'name' => 'method',
		'value' => $value,
		'options' => array(
			elgg_echo('member_selfdelete:explain:anonymize') => 'anonymize',
			elgg_echo('member_selfdelete:explain:ban') => 'ban',
			elgg_echo('member_selfdelete:explain:delete') => 'delete',
		),
	);

	echo elgg_view('input/radio', $options);
}

if (elgg_get_plugin_setting('feedback', PLUGIN_ID) == "yes") {
	echo '<div class="pvs">';
	echo "<label>" . elgg_echo('member_selfdelete:label:reason') . "</label>";
	echo elgg_view('input/longtext', array(
		'name' => 'reason',
		'value' => elgg_get_sticky_value('member_selfdelete', 'reason')
	));
	echo '</div>';
}

echo '<div class="pvs">';
echo "<label>" . elgg_echo('member_selfdelete:label:confirmation') . '</label>';
echo elgg_view('input/password', array(
	'name' => 'confirmation'
));
echo '</div>';

echo '<div class="elgg-foot">';
echo elgg_view('input/submit', array('value' => elgg_echo('member_selfdelete:submit')));
echo '</div>';

elgg_clear_sticky_form('member_selfdelete');
