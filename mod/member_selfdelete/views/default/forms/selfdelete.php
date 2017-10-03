<?php

namespace Beck24\MemberSelfDelete;

$explanation = elgg_echo('member_selfdelete:explain:' . elgg_get_plugin_setting('method', PLUGIN_ID));
echo elgg_view('output/longtext', array(
	'value' => $explanation
));


$dbprefix = elgg_get_config('dbprefix');
$owned_groups = elgg_get_entities(array(
		'type' => 'group',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'joins' => array("JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid"),
		'order_by' => 'ge.name ASC',
		'full_view' => false,
		'no_results' => elgg_echo('groups:none'),
		'distinct' => false,
));

if($owned_groups){
    echo '<div class="row clearfix">';
    foreach($owned_groups as $group){
        $owner_guid = $group->getOwnerGUID();
        $members[$owner_guid] = get_entity($owner_guid)->name ."  (@". get_entity($owner_guid)->username .")";
        echo '<div class="list-break clearfix">';
        echo '<div class="col-md-8 ">';
        echo elgg_view('group/default', array('entity' => $group));
        echo '</div><div class="col-md-4 mrgn-tp-md"><div>';
        echo elgg_view("input/text", array(
				"id" => "groups-owner-guid",
				"value" =>  get_entity($owner_guid)->name,
			));

			echo elgg_view("input/select", array(
				"name" => "owner_guid",
				"id" => "groups-owner-guid-select",
				"value" =>  $owner_guid,
				"options_values" => $members,
				"class" => "groups-owner-input hidden",
			));

			$vars = array(
				'class' => 'mentions-popup hidden',
				'id' => 'groupmems-popup',
			);

			echo elgg_view_module('popup', '', elgg_view('graphics/ajax_loader', array('hidden' => false)), $vars);

			if ($owner_guid == elgg_get_logged_in_user_guid()) {
				echo "<span class='elgg-text-help'>" . elgg_echo("groups:owner:warning") . "</span>";
			}
        echo elgg_view('output/url', array(
            'text'=>'Change',
            'class'=>'btn btn-primary mrgn-rght-sm elgg-lightbox',
            'href'=>'ajax/view/member_selfdelete/group_membership_change',
        ));
        echo '</div></div></div>';
    }
    echo '</div>';
}
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
