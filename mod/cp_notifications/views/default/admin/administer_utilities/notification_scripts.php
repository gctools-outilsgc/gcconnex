<?php
//NOTIFICATION
echo "<p>";
echo elgg_view('cp_notifications/admin_nav');
echo "</p>";
$title = elgg_echo('elgg_solr:settings:title:adapter_options');

$dbprefix = elgg_get_config('dbprefix');





			echo "<br /><h3>Bulk-subscribe users to their content</h3>";
			echo elgg_view("output/url",
				array(
					'href' => elgg_get_site_url().'admin/plugin_settings/cp_notifications',
					'text' => '<< back to settings page',
				)
			);
			echo "<br />";

			$str_id = elgg_get_metastring_id('set_personal_subscription', true);
			$val_id = elgg_get_metastring_id('0');
			$query = "SELECT count(guid) as num_users FROM {$db_prefix}users_entity u LEFT JOIN (SELECT * FROM {$db_prefix}metadata WHERE name_id = {$str_id}) md ON u.guid = md.entity_guid WHERE md.value_id = {$val_id}";

			$count = get_data_row($query);

			echo elgg_view('admin/upgrades/view', array(
				'count' => $count->num_users,
				'action' => 'action/cp_notifications/set_personal_subscription',
			));
			
		

	
			echo "<br /><h3>Revert bulk-subscription of users to their content</h3>";
			echo elgg_view("output/url",
				array(
					'href' => elgg_get_site_url().'admin/plugin_settings/cp_notifications',
					'text' => '<< back to settings page',
				)
			);
			echo "<br />";

			$personal_degrade_label = "Run Script to ROLL BACK Personal-generated content subscription: ";

			$str_id = elgg_get_metastring_id('set_personal_subscription');
			$val_id = elgg_get_metastring_id('1');
			$query = "SELECT count(guid) as num_users FROM {$db_prefix}users_entity u LEFT JOIN (SELECT * FROM {$db_prefix}metadata WHERE name_id = {$str_id}) md ON u.guid = md.entity_guid WHERE md.value_id = {$val_id}";

			$count = get_data_row($query);

			echo elgg_view('admin/upgrades/view', array(
				'count' => $count->num_users,
				'action' => 'action/cp_notifications/reset_personal_subscription',
			));
			



			echo "<br /><h3>Bulk-subscribe users to group content</h3>";
			echo elgg_view("output/url",
				array(
					'href' => elgg_get_site_url().'admin/plugin_settings/cp_notifications',
					'text' => '<< back to settings page',
				)
			);
			echo "<br />";
			$access_status = access_get_show_hidden_status();
			access_show_hidden_entities(true);

			$str_id = elgg_get_metastring_id('subscribed_to_all_group_content', true);	// get the metastring id, create the metastring if it does not exist

			
			$count = get_data_row("SELECT count(*) as users from {$db_prefix}users_entity u LEFT JOIN ( SELECT * from {$db_prefix}metadata WHERE name_id = {$str_id} ) md ON u.guid = md.entity_guid WHERE md.value_id IS NULL");

			echo elgg_view('admin/upgrades/view', array(
				'count' => $count->users,
				'action' => 'action/cp_notifications/subscribe_users_to_group_content',
			));

			access_show_hidden_entities($access_status);
			


			echo "<br /><h3>Revert bulk-subscription of users to group content</h3>";
			echo elgg_view("output/url",
				array(
					'href' => elgg_get_site_url().'admin/plugin_settings/cp_notifications',
					'text' => '<< back to settings page',
				)
			);
			echo "<br />";
			$access_status = access_get_show_hidden_status();
			access_show_hidden_entities(true);

			$str_id = elgg_get_metastring_id('subscribed_to_all_group_content', true);	// get the metastring id, create the metastring if it does not exist

			$db_prefix = elgg_get_config('dbprefix');
			$count = get_data_row("SELECT count(*) as users from {$db_prefix}users_entity u LEFT JOIN {$db_prefix}metadata md ON u.guid = md.entity_guid WHERE md.name_id = {$str_id}");

			echo elgg_view('admin/upgrades/view', array(
				'count' => $count->users,
				'action' => 'action/cp_notifications/undo_subscribe_users_to_group_content',
			));

			access_show_hidden_entities($access_status);
		




			// admin-option only to run the script auto-subscribe their personal contents
			echo "<div>";
			echo "Run Script for Personal-generated content subscription : ";
			$btn_run_personal_script = elgg_view("output/confirmlink",
				array(
					'href' => elgg_get_site_url().'action/cp_notifications/set_personal_subscription',
					'text' => 'Click to Run Script',
					'confirm' => 'Are you sure you want to run the script?'
				)
			);

			echo $btn_run_personal_script;
			echo "<br />";
			echo elgg_view("output/url",
				array(
					'href' => '?script=personal',
					'text' => 'personal notifications script',
					'class' => 'btn btn-default elgg-button btn-primary elgg-button-submit only-one-click',
				)
			);
			echo "  ";
			echo elgg_view("output/url",
				array(
					'href' => '?script=undo_personal',
					'text' => 'undo personal notifications script',
					'class' => 'btn btn-default elgg-button btn-primary elgg-button-submit only-one-click',
				)
			);
			echo "</div>";

			echo "<div>";
			echo "Run Script for Group-generated content subscription: <br />";
			echo elgg_view("output/url",
				array(
					'href' => '?script=groups',
					'text' => 'group script',
					'class' => 'btn btn-default elgg-button btn-primary elgg-button-submit only-one-click',
				)
			);
			echo "  ";
			echo elgg_view("output/url",
				array(
					'href' => '?script=undo_groups',
					'text' => 'undo group script',
					'class' => 'btn btn-default elgg-button btn-primary elgg-button-submit only-one-click',
				)
			);
			echo "</div>";





			// list all users who have group subscriptions and are not members of
			echo "<br/><br/>";
			echo "<h3>Run to fix inconsistent group subscriptions/members Script</h3>";
			echo "<div>";

			$str_id = elgg_get_metastring_id('fixing_notification_inconsistencies', true);
			$val_id = elgg_get_metastring_id('0');

			$query = "	SELECT COUNT(r1.guid_one) AS num_users
						FROM {$db_prefix}entity_relationships r1
						LEFT OUTER JOIN {$db_prefix}entity_relationships r2 ON r1.guid_two = r2.guid_two AND r2.relationship = 'member' AND r1.guid_one = r2.guid_one
						WHERE
							r1.guid_one IN (select guid FROM {$db_prefix}users_entity)
							AND r1.relationship LIKE 'cp_subscribed_to%'
							AND r1.guid_two IN (select guid FROM {$db_prefix}groups_entity)
							AND r2.relationship is null";

			$count = get_data_row($query);

			echo elgg_view('admin/upgrades/view', array(
				'count' => $count->num_users,
				'action' => 'action/cp_notifications/fix_inconsistent_subscription_script',
			));

			echo "</div> <br/><br/>";




echo elgg_view_module('main', $title, $body);

