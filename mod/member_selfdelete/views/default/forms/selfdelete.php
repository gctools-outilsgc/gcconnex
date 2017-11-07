<?php

namespace Beck24\MemberSelfDelete;


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
echo '<p class="mrgn-bttm-sm">'.elgg_echo('member_selfdelete:gc:reasonforleave').'</p>';
echo elgg_view('input/radio',array(
	'name'=>'gcreason',
	'options' =>array(
		elgg_echo('member_selfdelete:gc:reason:tempandknow') => "tempandknow",
		elgg_echo('member_selfdelete:gc:reason:retire') => "retire",
		elgg_echo('member_selfdelete:gc:reason:tempnotknow') => "tempnotknow",
		elgg_echo('member_selfdelete:gc:reason:notifs') => "notifs",
		elgg_echo('member_selfdelete:gc:reason:useful') => "useful",
		elgg_echo('member_selfdelete:gc:reason:understand') => "understand",
		elgg_echo('member_selfdelete:gc:reason:other'). elgg_view('input/text',array('name'=>'gcreason_oth')) => "other",
	),
	'class'=> 'deactivate-radios',
));
echo "<label>" . elgg_echo('member_selfdelete:label:confirmation');
echo elgg_view('input/password', array(
	'name' => 'confirmation',
	'class' => 'deactivate-password',
));
echo '</label></div>';

echo '<div class="elgg-foot">';
echo '<div class="error deactivate-error"></div>';
echo elgg_view('input/submit', array('value' => elgg_echo('member_selfdelete:submit')));
echo '</div>';

elgg_clear_sticky_form('member_selfdelete');
//scripts below handle form states like if a user has group ownership
?>

<script>
$(document).ready(function(){
	var formCount = $('.self-deactivate-memember-form');
	formCount = formCount.length;
	if(formCount>=1){
		$('.elgg-form-selfdelete').find('.elgg-button-submit').prop('disabled', true);
		$('.elgg-form-selfdelete').find('.elgg-button-submit').addClass('deactivate-submit');
		$('.elgg-form-selfdelete .deactivate-error').append(<?php echo "'<span>" .elgg_echo('member_selfdelete:gc:error:group') ."</span>'";?>);
	}
});
</script>
<style>
	.deactivate-radios input{
		margin:0px 5px;
	}
	.deactivate-password{
		width:250px;
	}
	.deactivate-error span{
		background: #f3e9e8;
		padding: 2px 6px;
		margin: 3px 0px;
		font-weight: bold;
		display:inline-block;
		border-left: 5px solid #d3080c;
	}
	.deactivate-submit{
		display:block;
	}
	.deactivate-group-holder{
		border-bottom: 1px #ddd solid;
		margin-bottom:8px;
	}
	.self-deactivate-memember-form .elgg-input-text{
		width:75%;
		display: inline-block;
	}
	.self-deactivate-memember-form .elgg-button-submit{
		width:25%;
		display:inline-block;
	}
	.self-groupmems-popup{
		position:absolute;
		width:73%;
	}

</style>