<?php

gatekeeper();

$user = elgg_get_page_owner_entity();
$plugin = elgg_extract("entity", $vars);
$dbprefix = elgg_get_config('dbprefix');
$db_prefix = elgg_get_config('dbprefix');

// easily accessible to the user settings page to change their email
$change_email_link = "<a href='".elgg_get_site_url()."settings/user/'>".elgg_echo('label:email')."</a>";
$title = elgg_echo('cp_notify:panel_title',array($change_email_link));

// we don't need to have notifications for widget, forum category, skills, etc...
$no_notification_available = array('widget','hjforumcategory','messages','MySkill','experience','education','hjforumpost','hjforumtopic','hjforum');	// set all the entities that we want to exclude
	


/* cyu - allow users to opt-in for script
 * 	only display option when it is set in the admin panel of the site
 */
$allow_opt_out = elgg_get_plugin_setting('cp_notifications_opt_out','cp_notifications');
if ($allow_opt_out === 'yes') {
	$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
	$content .= '<div class="col-sm-12 clearfix"> <h3 class="well">'. "Opt-out to allow subscriptions turned on (limited time only)" .'</h3> </div>'; // translate

	$user_option = $plugin->getUserSetting("cpn_set_optout", $user->getGUID());

	$val_want_sub = false;	// default - want to subscribe
	if ($user_option === 'auto_sub' || !$user_option)
		$val_want_sub = true;

	/* True 	- Do want auto-subscribed
	 * False 	- Do not want auto-subscribed
	 */
	$chk_opt_out = elgg_view('input/checkbox', array(
						'name'=> "params[cpn_set_optout]",
						'value'=> 'auto_sub',
						'default'=> 'do_not_auto_sub',
						'checked'=> $val_want_sub,
						'label'=> 'I want to subscribe to all my contents' // translate
					));

	$content .= "<div class='col-sm-8'>{$chk_opt_out}</div>";
}




/* Nick - adding areas for personal notifications
 * 	display the area for personal notifications
 */
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '<div class="col-sm-12 clearfix"> <h3 class="well">'.elgg_echo('cp_notify:personalNotif').'</h3>';

$personal_notifications = array('likes','mentions','content'); // likes mentions content

if (elgg_get_plugin_setting('cp_notifications_enable_bulk','cp_notifications') === 'yes')
	$personal_notifications[] = 'bulk_notifications';

foreach ($personal_notifications as $label) {

	// grab the user setting that's been saved
	$email_value = $plugin->getUserSetting("cpn_{$label}_email", $user->getGUID());
	$site_value = $plugin->getUserSetting("cpn_{$label}_site", $user->getGUID());

	// default settings
	$e_chk_value = true;
	if ($email_value === "{$label}_email_none" || !$email_value)
		$e_chk_value = false;

	$s_chk_value = true;
	if ($site_value === "{$label}_site_none" || !$site_value)
		$s_chk_value = false;

	// display the label for likes, @mentions, comment and bulk email (if applicable)
	$content .= '<div class="col-sm-8">'.elgg_echo("cp_notify:personal_{$label}").'</div>';

	$chk_email = elgg_view('input/checkbox', array(
					'name' => "params[cpn_{$label}_email]",
					'value' => "{$label}_email",
					'default' => "{$label}_email_none",
					'checked' => $e_chk_value,
					'label' => elgg_echo('label:email')
		));

	$content .= "<div class='col-sm-2'>{$chk_email}</div>";

	$chk_site_mail = elgg_view('input/checkbox', array(
					'name' => "params[cpn_{$label}_site]",
					'value' => "{$label}_site",
					'default' =>"{$label}_site_none",
					'checked' => $s_chk_value,
					'label' => elgg_echo('label:site')
			));

	$content .= "<div class='col-sm-2'>{$chk_site_mail}</div>";

}

$content .= '</div>';






/* Nick - Add colleague notifications area
 *
 */
$colleagues = elgg_get_logged_in_user_entity()->getFriends(array('limit' => 0));
$subbed_colleagues = elgg_get_entities_from_relationship( array(
	'relationship' => 'cp_subscribed_to_site_mail',
	'relationship_guid' => $user->guid,
	'type' => 'user',
	'limit' => 0,) );
foreach( $subbed_colleagues as $c )
	$subbed_colleague_guids[] = $c->getGUID();

$cpn_coll_notif_checkbox = elgg_view('input/checkboxes', array(
    'name' => "params[cpn_notif_{$user->getGUID()}]", // might need to pass something else here to get this to work
    'value' => 'test',
    'options' => $cpn_notification_options,
    'multiple' => true,
    'checked' => true,
    'class' => 'list-unstyled list-inline notif-ul',
));
// Nick - Commenting out the Colleague notification section for now
$colleague_picker = elgg_view('input/friendspicker', array('entities' => $colleagues, 'name' => 'colleagues_notify_sub', 'value' => $subbed_colleague_guids));
 
$content .='<div class="col-sm-12"><h3 class="well">'.elgg_echo('cp_notify:collNotif').'</h3>';

// Nick - Coming soon message added for colleague notifications
//$content .= '<div>'.elgg_echo('cp_notify:comingSoon').'</div>';

// cyu - formatting was a little off
$content .= '<div class="col-sm-8">' . elgg_echo('cp_notify:colleagueContent').'</div>';
$content .= '<div class="col-sm-4">' . $cpn_coll_notif_checkbox.'</div>';
$content .= '<div class="accordion col-sm-12 clearfix mrgn-bttm-sm">';
$content .= '	<div class="tgl-panel clearfix">';
$content .= '		<details class="acc-group" >';
$content .= '	<br/>	';
$content .= '			<summary class="wb-toggle tgl-tab">'.elgg_echo('cp_notify:pickColleagues').'</summary>';
$content .= "			<div class='col-sm-12 clearfix'> {$colleague_picker} </div>";
$content .= '		</details>';
$content .= '	</div>';
$content .= '</div>';




/* displays the Group notification section
 *
 */

$group_page = get_input('gs', 0);
$content .= '<div class="col-sm-12 group-notification-options"><h3 class="well">'.elgg_echo('cp_notify:groupNotif').'</h3>';

// cyu - implement a subscribe to all group and their content (TODO: perhaps build a time cooldown for this)
$url_sub = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/cp_notifications/user_autosubscription?sub=sub");
$url_unsub = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/cp_notifications/user_autosubscription?sub=unsub");

$content .= "<div style='padding-bottom:50px;'>";
$content .= "<div style='border:1px solid black; padding: 2px 2px 2px 10px;'> <center><a href='{$url_sub}'> ".elgg_echo('cp_notify:subscribe_all_label',array($url_sub,$url_unsub))." </a></center> </div>";
$content .= "</div>";

//$content .= "<div style='padding-bottom:50px;'>";
//$content .= "<div style='border:1px solid black; padding: 2px 2px 2px 10px;'> <center><a href='{$url_unsub}'> ".elgg_echo('cp_notify:unsubscribe_all_label')." </a></center> </div>";
//$content .= "</div>";


// This checkbox  is if you want to recieve emails about group notifications. it needs to toggle all the email check boxes
$chk_all_email = elgg_view('input/checkbox', array(
	'name' => "params[cpn_group_email_{$user->getGUID()}]",
	'value'=>'',
	'label'=>elgg_echo('cp_notify:emailsForGroup'),
	'class'=>'all-email'
));

$content .= "<div class='clearfix brdr-bttm mrgn-bttm-sm'>";
$content .= "<div class='col-sm-2 col-sm-offset-8 mrgn-bttm-md'>{$chk_all_email}</div>";

$chk_all_site_mail = elgg_view('input/checkbox', array(
	'name' => "params[cpn_group_site_{$user->getGUID()}]",
	'value'=>'',
	'label' => elgg_echo('cp_notify:siteForGroup'),
	'class'=>'all-site'
));

$content .= "<div class='col-sm-2 mrgn-bttm-md'>{$chk_all_site_mail}</div></div>";

// script to check all email and site mail's group checkboxes
$content .='<script>$(".all-email").click(function(){$(".group-check").prop("checked", this.checked);$(".group-check").trigger("change")})</script>';
$content .='<script>$(".all-site").click(function(){$(".group-site").prop("checked", this.checked);$(".group-site").trigger("change")})</script>';


$group_limit = elgg_get_plugin_setting('cp_notifications_display','cp_notifications');
if (!$group_limit) $group_limit = 10; // cyu - default value if none is set

$group_offset = (int)$group_page * (int)$group_limit;

// cyu - get user's groups that they've joined
$options = array(
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'type' => 'group',
	'joins' => array("INNER JOIN {$dbprefix}groups_entity g ON (e.guid = g.guid)"), // cyu - order by alphabetical by group name
	'order_by' => 'g.name',
	'offset' => $group_offset,
	'limit' => $group_limit, // cyu - needs to have a limit, the page will time out
);

$groups = elgg_get_entities_from_relationship($options);

$user_guid = elgg_get_logged_in_user_guid();
$query = "SELECT count(guid) AS num_group FROM {$db_prefix}groups_entity g, {$db_prefix}entity_relationships r WHERE g.guid = r.guid_two AND r.relationship = 'member' AND r.guid_one = {$user_guid}";
$ng = get_data($query);
$number_of_grp_pages = (int)$ng[0]->num_group / (int)$group_limit;

foreach ($groups as $group) {
	$content .= "<div class='list-break clearfix'>";

    // Nick - This asks for the inputs of the checkboxes. If the checkbox is checked it will save it's value. else it will return 'unSub' or 'site_unSub'
	$cpn_set_subscription_email = $plugin->getUserSetting("cpn_email_{$group->getGUID()}", $user->getGUID());	// setting email notification

	// email - if user set item to subscribed, and no relationship has been built, please add new relationship
    if ( get_data("SELECT count(*) AS subed FROM {$db_prefix}entity_relationships WHERE guid_one = {$user->guid} AND relationship = 'cp_subscribed_to_email' AND guid_two={$group->guid}")[0]->subed )
		$cpn_grp_email_checked = true;
	else // (email) if user set item to unsubscribe, update relationship table
		$cpn_grp_email_checked = false;

	if (empty($cpn_set_subscription_email)) $cpn_set_subscription_email = 'sub_'.$group->getGUID() ; // if not set, set no email as default


	$cpn_set_subscription_site_mail = $plugin->getUserSetting("cpn_site_mail_{$group->getGUID()}", $user->getGUID());
	
	// site mail - checks for the inputs of the check boxes
	if ( get_data("SELECT count(*) AS subed FROM {$db_prefix}entity_relationships WHERE guid_one = {$user->guid} AND relationship = 'cp_subscribed_to_site_mail' AND guid_two={$group->guid}")[0]->subed )
        $cpn_grp_site_mail_checked =true;
	else 
        $cpn_grp_site_mail_checked =false;

	if (empty($cpn_set_subscription_site_mail)) $cpn_set_subscription_site_mail = 'sub_site_'.$group->getGUID();


	// get group contents
	$options = array(
		'container_guid' => $group->guid,
		'type' => 'object',
		'limit' => false,
	);
	$group_contents = elgg_get_entities($options);

    // Nick - checkboxes for email and site. if they are checked they will send 'sub_groupGUID' if not checked they will send 'unSub'
    $cpn_grp_email_checkbox = elgg_view('input/checkbox', array(
        'name' => "params[cpn_email_{$group->getGUID()}]",
        'value'=> 'sub_'.$group->getGUID(),
        'label'=> elgg_echo('label:email'),
        'default'=>'unSub',
        'checked'=> $cpn_grp_email_checked,
        'class'=> 'group-check',
    ));

    $cpn_grp_site_checkbox = elgg_view('input/checkbox', array(
        'name' => "params[cpn_site_mail_{$group->getGUID()}]",
        'value'=> 'sub_site_'.$group->getGUID(),
        'label'=>'Site',
        'default'=>'site_unSub',
        'checked'=> $cpn_grp_site_mail_checked,
        'class'=> 'group-site',
    ));




	// GROUP CONTENT SUBSCRIPTIONS
	$content .= "<div class=' '>";
	$content .= "<div class='namefield col-sm-8'> <strong> <a href='{$group->getURL()}' id='group-{$group->guid}'>{$group->name}</a> </strong> </div>";

    $content .= '<div class="col-sm-2">'.$cpn_grp_email_checkbox.'</div>'; // Nick - Here are the group checkboxes
    $content .= '<div class="col-sm-2">'.$cpn_grp_site_checkbox.'</div>';
	$content .= "</div>";

	$cp_table_tr_count = 0;

	foreach ($group_contents as $group_content) {
		if (!in_array($group_content->getSubtype(), $no_notification_available)) {

			// cyu - i don't think we really need this block of code
			/*
			$cpn_set_subscription_email = $plugin->getUserSetting("cpn_email_{$group_content->getGUID()}", $user->getGUID());	// setting email notification

			// if user set item to subscribed, and no relationship has been built, please add new relationship
			if ($cpn_set_subscription_email === elgg_echo("cp_notify:subscribe") && !check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group_content->getGUID()))
				add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group_content->getGUID());
			// if user set item to unsubscribe, update relationship table
			if ($cpn_set_subscription_email === elgg_echo("cp_notify:unsubscribe") && check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group_content->getGUID()))
				remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group_content->getGUID());

			if (empty($cpn_set_subscription_email)) $cpn_set_subscription_email = elgg_echo("cp_notify:unsubscribe");	// if not set, set no email as default

			$cpn_set_subscription_site_mail = $plugin->getUserSetting("cpn_site_mail_{$group_content->getGUID()}", elgg_get_page_owner_guid());
			if (empty($cpn_set_subscription_site_mail)) $cpn_set_subscription_site_mail = elgg_echo("cp_notify:subscribe");

			// get subscribed items that are contained in group
			if (check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group_content->getGUID()))
				$cpn_set_subscription_email = elgg_echo("cp_notify:subscribe");
			else
				$cpn_set_subscription_email = elgg_echo("cp_notify:unsubscribe");
			*/

            $cpn_unsub_btn = elgg_view('input/button', array( //Unsub button, when this is clicked it runs a JS function to call the unsub action
                'src' => '#', //put the unsub action to the object here
                'class' =>'btn btn-default unsub-button',
                'id'=> $group_content->getGUID() .'_b',
                'value' => elgg_echo("cp_notify:unsubscribe"),
            ));

            if (check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group_content->getGUID())) {
            	// Nick - only display group content the user is subscribed to.
                $cp_table_tr_count++;	// so we can display a message when the user does not have anything subscribed to
                $sub_group_content .= "<div class='clearfix col-sm-12 list-break'>";
                $sub_group_content .= "		<div class='togglefield col-sm-10'>";
				$sub_group_content .= "			<p><a href='{$group_content->getURL()}'>{$group_content->title}</a></p>";
				$sub_group_content .= "			<sup>".cp_translate_subtype($group_content->getSubtype())."</sup>";
				$sub_group_content .= "		</div>";	// column: content name
				$sub_group_content .= "		<div class='col-sm-2'> {$cpn_unsub_btn} </div>";	// column: send by e-mail
                $sub_group_content .= "</div>";
            }

		}
	} 

    if ($cp_table_tr_count >= 1) { // NICK - if you have content in the group you are subbed to display the accordion
        $content .= '<div class="accordion col-sm-12 clearfix mrgn-bttm-sm"><details class="acc-group"> <summary class="wb-toggle tgl-tab">'.elgg_echo('cp_notify:groupContent').'</summary>';
        $content .= '<div class="tgl-panel clearfix">';
        $content .= '<div>' ;
        $content .= $sub_group_content;
        $content .= '</div>';

        $content .= '</div></details></div>';
    }
    $content .='</div>';

    $sub_group_content =''; // Nick - reset content2 for next group

} // cyu - end loop for the group

$content .= "</section>";

$site = elgg_get_site_entity();
$number_of_grp_pages;
$current_user = elgg_get_logged_in_user_entity();

// do pagination
$content .= "<div align='center'>";
for ($x = 0; $x <= $number_of_grp_pages; $x++)
	$content .= "[ <a href='{$site->getURL()}settings/plugins/{$current_user->username}/cp_notifications?gs={$x}'>{$x}</a> ]";
$content  .= "</div>";






/* PERSONAL SUBSCRIPTIONS: this section displays all the items that are subscribed (this excludes the group content)
 * cyu - fix for JIRA # GCCON-107
 */

$current_user = elgg_get_logged_in_user_entity();

// build a base query (so we can use it to count all the results, and display all the items)
// cyu - patched issue with personal subscription that contains group content
$content_arr = array('blog','bookmark','event_calendar','file','hjforumtopic','hjforum','photo','album','task','page','page_top','task_top','idea','thewire');
$query_base = " FROM {$dbprefix}entity_subtypes es, {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity o WHERE e.container_guid  NOT IN (SELECT guid FROM {$dbprefix}groups_entity) AND e.subtype = es.id AND o.description <> '' AND o.guid = e.guid AND o.guid = r.guid_two AND r.guid_one = {$current_user->getGUID()} AND r.relationship = 'cp_subscribed_to_email' AND ( es.subtype = 'poll' ";
foreach ($content_arr as $content_element)
	$query_base .= " OR es.subtype = '{$content_element}'";
$query_base .= " ) ";


// query that will display all the subscribed items
$personal_limit = elgg_get_plugin_setting('cp_notifications_display','cp_notifications');
if (!$personal_limit) $personal_limit = 10;
$personal_page = get_input('ps', 0); // TODO: needs to be changed
$personal_offset = (int)$personal_page * (int)$personal_limit;

$query_select = "SELECT e.guid, e.subtype as entity_subtype, es.subtype, o.title, o.description {$query_base}";
$query_select .= " ORDER BY e.subtype ASC LIMIT {$personal_limit} OFFSET {$personal_offset}";
$subbed_contents = get_data($query_select);

//$content .= "{$query_select}";

// query that will count all the subscribed items
$query_count = "SELECT count(e.guid) AS num_content {$query_base}";
$np = get_data($query_count);
$number_of_personal_pages = (int)$np[0]->num_content / (int)$personal_limit;


// display the list of items that are subscribed
$cp_count = 0;
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '<div class="col-sm-12 group-notification-options"><h3 class="well">'.elgg_echo('cp_notify:personal_setting').'</h3></div>';

foreach ($subbed_contents as $subbed_content) {
	$content_title = $subbed_content->title;
	if (!$content_title) $content_title = elgg_echo('cp_notify:wirepost_generic_title');


	// cyu - clean up the html tags from the description
	$content_desc = trim($subbed_content->description);

	$content_desc = str_replace('\r\n', '', $content_desc);
	$content_desc = str_replace('\n', '', $content_desc);
	$content_desc = str_replace('\r', '', $content_desc);
	
	$content_desc = preg_replace('/[\s]+/','',$content_desc);
	$content_desc = preg_replace("/<[a-zA-Z ]+>|<\/[a-zA-Z]+>/",'',$content_desc);

	$content_desc = strip_tags($content_desc);

	if (strlen($content_desc) >= 40)
		$content_desc = substr($content_desc, 0, 45).'...';

	$cpn_unsub_btn = elgg_view('input/button', array(
		'src'=> '#', // put the unsub action to the object here
		'class'=> 'btn btn-default unsub-button',
		'id'=> $subbed_content->guid.'_unsub',
		'value'=> elgg_echo("cp_notify:unsubscribe"),
		'align' => 'right',
	));

	// form the url
	$entity_content = get_entity($subbed_content->guid);

	if (strcmp($subbed_content->subtype,'hjforum') == 0) {
		$group_id = get_forum_in_group($subbed_content->guid, $subbed_content->guid);
		$url = "{$site->getURL()}gcforums/group/{$group_id}/{$subbed_content->guid}";
	} else if (strcmp($subbed_content->subtype,'hjforumtopic') == 0)
		$url = "{$site->getURL()}gcforums/group/{$group_id}/{$subbed_content->guid}/{$subbed_content->subtype}";
	else
		$url = $entity_content->getURL();



	$content .= "<div class='clearfix col-sm-12 list-break'>";
	$content .= "<div class='togglefield col-sm-10'> <a href='{$url}'><strong>{$content_title}</strong></a> - {$content_desc}  <sup>{$subbed_content->subtype}</sup> </div>";
	$content .= "<div class=' col-sm-2'> {$cpn_unsub_btn} </div>";
	$content .= "</div>";

	$cp_count++;
}

if ($cp_count <= 0)
	$content .= elgg_echo('cp_notify:no_subscription')."<br/>";

// do pagination
$content .= "<div align='center'>";
for ($x = 0; $x <= $number_of_personal_pages; $x++)
	$content .= "[ <a href='{$site->getURL()}settings/plugins/{$current_user->username}/cp_notifications?gs={$group_page}&ps={$x}'>{$x}</a> ]";
$content .= "</div>";


$content .= "</section>";

if (strcmp(elgg_get_plugin_setting('cp_notifications_sidebar','cp_notifications'), 'yes') == 0)
	echo elgg_extend_view('page/elements/sidebar','cp_notifications/sidebar');

echo elgg_view_module('info', $title, $content);


// recursive, to get group id
function get_forum_in_group($entity_guid_static, $entity_guid) {
	$entity = get_entity($entity_guid);
	if ($entity instanceof ElggGroup) { // stop recursing when we reach group guid
		//error_log('stop at GUID: '.$entity_guid.' / '.$entity->name);
		return $entity_guid;
	} else { // keep going...
		return get_forum_in_group($entity_guid_static, $entity->getContainerGUID());
	}
}
