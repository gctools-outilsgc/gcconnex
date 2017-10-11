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
echo '<label>'.elgg_echo('member_selfdelete:gc:reasonforleave').'</label>';
echo elgg_view('input/radio',array(
	'name'=>'gcreason',
	'options' =>array(
		elgg_echo('member_selfdelete:gc:reason:temp') => "temp",
		elgg_echo('member_selfdelete:gc:reason:retire') => "retire",
		elgg_echo('member_selfdelete:gc:reason:understand') => "understand",
		elgg_echo('member_selfdelete:gc:reason:notifs') => "notifs",
		elgg_echo('member_selfdelete:gc:reason:useful') => "useful",
		elgg_echo('member_selfdelete:gc:reason:time') => "time",
		elgg_echo('member_selfdelete:gc:reason:hacked') => "hacked",
		elgg_echo('member_selfdelete:gc:reason:other'). elgg_view('input/text',array('name'=>'gcreason_oth')) => "other",
	),
	'class'=> '',
));
echo "<label>" . elgg_echo('member_selfdelete:label:confirmation') . '</label>';
echo elgg_view('input/password', array(
	'name' => 'confirmation'
));
echo '</div>';

echo '<div class="elgg-foot">';
echo elgg_view('input/submit', array('value' => elgg_echo('member_selfdelete:submit')));
echo '</div>';

elgg_clear_sticky_form('member_selfdelete');
//scripts below 
?>

<script>
$(document).ready(function(){
	var formCount = $('.self-deactivate-memember-form');
	formCount = formCount.length;
	if(formCount>=1){
		$('.elgg-form-selfdelete').find('.elgg-button-submit').prop('disabled', true);
		$('.elgg-form-selfdelete').append('Please fix your groups man cmon');
	}
});
</script>