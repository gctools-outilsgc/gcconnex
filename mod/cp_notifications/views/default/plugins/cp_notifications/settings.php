<?php
	$page_mode = get_input('script', 'default');
	$db_prefix = elgg_get_config('dbprefix');

	switch ( $page_mode ) {
		case 'personal':		// Enable all personal notification serrings for all users
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
			break;
		

		case 'undo_personal':	// undo the above
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
			break;


		case 'groups':			// Subscribe all users to all content is their groups
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
			break;


		case 'undo_groups':		// undo the above
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
			break;

		default:		// the actual settings page
			// default value
			if (!isset($vars['entity']->cp_notifications_email_addr))
				$vars['entity']->cp_notifications_email_addr = 'admin.gcconnex@tbs-sct.gc.ca';

if (!isset($vars['entity']->cp_notifications_email_addr))
	$vars['entity']->cp_notifications_email_addr = 'admin.gcconnex@tbs-sct.gc.ca';

			if (!isset($vars['entity']->cp_notifications_opt_out))
				$vars['entity']->cp_notifications_opt_out = 'no';

			if (!isset($vars['entity']->cp_notifications_enable_bulk))
				$vars['entity']->cp_notifications_enable_bulk = 'no';

if (!isset($vars['entity']->cp_notifications_sidebar))
	$vars['entity']->cp_notifications_sidebar = 'no';

			echo "<br/><br/>";

			// display and allow admin to change the reply email (will be modified in the header)
			echo "<div>";
			echo "Email Address to be used";
			echo elgg_view('input/text', array(
				'name' => 'params[cp_notifications_email_addr]',
				'value' => $vars['entity']->cp_notifications_email_addr,
			));
			echo "</div>";


			// display option to allow users to opt-out of the auto-subscription
			echo "<div>";
			echo "Allow users to opt-out to have all their stuff subscribed : ";
			echo elgg_view('input/select', array(
				'name' => 'params[cp_notifications_opt_out]',
				'options_values' => array(
					'no' => elgg_echo('option:no'),
					'yes' => elgg_echo('option:yes')
				),
				'value' => $vars['entity']->cp_notifications_opt_out,
			));
			echo "</div>";


// display quick links for users (in user settings page for notifications)
echo "<div>";
echo "Enable Quick links sidebar for users : ";
echo elgg_view('input/select', array(
	'name' => 'params[cp_notifications_sidebar]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $vars['entity']->cp_notifications_sidebar,
));
echo "</div>";


			// display option to allow users to enable bulk e-mail notifications
			echo "<div>";
			echo "Enable Bulk Notifications : ";
			echo elgg_view('input/select', array(
				'name' => 'params[cp_notifications_enable_bulk]',
				'options_values' => array(
					'no' => elgg_echo('option:no'),
					'yes' => elgg_echo('option:yes')
				),
				'value' => $vars['entity']->cp_notifications_enable_bulk,
			));
			echo "</div>";




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
			break;
	}
