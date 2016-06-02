<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$access_value = get_user(elgg_get_page_owner_guid())->missions_hide_all_completed;
if($access_value === null) {
	$access_value = get_default_access();
}

$access_truth = false;
switch($access_value) {
	case 0:
		if(elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {
			$access_truth = true;
		}
		break;
	case 1:
		if(elgg_get_logged_in_user_entity()) {
			$access_truth = true;
		}
		break;
	case 2:
		$access_truth = true;
		break;
	case -2:
		if(get_user(elgg_get_page_owner_guid())->isFriendsWith(elgg_get_logged_in_user_guid()) || elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {
			$access_truth = true;
		}
		break;
}

$hidden_mission_array = explode(',', get_user(elgg_get_page_owner_guid())->missions_hide_list);

if(elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {
	$access_form .= elgg_view_form('missions_profile_extend/missions-access-form', array(
			'class' => 'form-horizontal'
	));
}

$entity_display = '';
if($access_truth) {
	$temp_array_one = elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_posted',
			'relationship_guid' => elgg_get_page_owner_guid()
	));
	$temp_array_two = elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_accepted',
			'relationship_guid' => elgg_get_page_owner_guid(),
			'inverse_relationship' => true
	));
	$entity_list = array_merge($temp_array_one, $temp_array_two);
	
	foreach($entity_list as $key => $entity) {
		if($entity->state == 'completed') {
			$is_not_hidden_mission = (array_search($entity->guid, $hidden_mission_array) === false);
			if($is_not_hidden_mission || elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {
				$feedback_search = elgg_get_entities_from_metadata(array(
						'type' => 'object',
						'subtype' => 'mission-feedback',
						'metadata_name_value_pairs' => array(
								array('name' => 'recipient', 'value' => elgg_get_page_owner_guid()),
								array('name' => 'mission', 'value' => $entity->guid),
								array('name' => 'endorsement', 'value' => 'on')
						)
				));
				
				$entity_link = elgg_view('output/url', array(
						'href' => $entity->getURL(),
						'text' => elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))
				));
				
				$entity_department = get_entity(mo_extract_node_guid($entity->department))->name;
				if(get_current_language == 'fr') {
					$entity_department = get_entity(mo_extract_node_guid($entity->department))->name_french;
				}
				
				$entity_button = '';
				if(elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {
					if($is_not_hidden_mission) {
						$entity_button = elgg_view('output/url', array(
				 				'href' => elgg_get_site_url() . 'action/b_extended_profile/hide-completed-mission?mid=' . $entity->guid . '&aid=' . elgg_get_page_owner_guid() ,
				 				'text' => elgg_echo('gcconnex_profile:hide'),
				 				'is_action' => true,
				 				'class' => 'elgg-button btn btn-danger',
				 				'style' => 'margin:2px;float:right;'
				 		));
					}
					else {
						$entity_button = $entity_button = elgg_view('output/url', array(
				 				'href' => elgg_get_site_url() . 'action/b_extended_profile/show-completed-mission?mid=' . $entity->guid . '&aid=' . elgg_get_page_owner_guid() ,
				 				'text' => elgg_echo('gcconnex_profile:show'),
				 				'is_action' => true,
				 				'class' => 'elgg-button btn btn-success',
				 				'style' => 'margin:2px;float:right;'
				 		));
					}
				}
				
				$entity_display .= '<div class="row" style="padding:8px;"><div class="col-sm-9">';
				$entity_display .= '<span style="font-weight:bold;">' . $entity_link . '</span><br>(' . date('Y-m-d', $entity->time_created) . ')<br>' . $entity_department;
				$entity_display .= '</div><div class="col-sm-3 gcconnex-avatar-in-list">';
				$entity_display .= $entity_button;
				foreach($feedback_search as $feedback) {
					$entity_display .= elgg_view_entity_icon(get_user($feedback->owner_guid), 'small');
				}
				$entity_display .= '</div></div>';
			}
		}
	}
}


?>

<div class="panel panel-custom">
	<div class="panel-heading profile-heading clearfix">
		<h3 class="profile-info-head pull-left clearfix"><?php echo elgg_echo('gcconnex_profile:opportunities'); ?></h3>
	</div>
	<?php echo $access_form; ?>
	<div class="gcconnex-profile-section-wrapper panel-body gcconnex-completed-missions">
		<?php echo $entity_display; ?>
	</div>
</div>