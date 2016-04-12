<?php

gatekeeper();

$user = elgg_get_page_owner_entity();
$options = array(
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'type' => 'group',
	'limit' => false,
);
$plugin = elgg_extract("entity", $vars);

$groups = elgg_get_entities_from_relationship($options);

$change_email_link = "<i><a href='".elgg_get_site_url()."settings/user/'> {$user->email}</a></i>";
$title = elgg_echo('cp_notify:panel_title',array($change_email_link));

$no_notification_available = array('widget','hjforumcategory','messages','MySkill','experience','education','hjforumpost','hjforumtopic','hjforum');	// set all the entities that we want to exclude


//Nick- adding areas for personal notifications
$cpn_notification_options = array('Email'=>'1', 'Site'=>'1',);
$cpn_personal_notif_checkbox = elgg_view('input/checkboxes', array(
    'name' => "params[cpn_notif_{$user->getGUID()}]",
    'value'=>'test',
    'options'=>$cpn_notification_options,
    'multiple' => true,
    'checked'=>true,
    'class'=>' list-unstyled list-inline notif-ul',
    ));


$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";

// Nick - Add personal notification area
$content .= '<div class="col-sm-12 clearfix"> <h3 class="well">Personal Notification</h3>';
$personal_notifications = array('likes','mentions','content'); // likes mentions content (code cleaned up)

foreach ($personal_notifications as $label) {
	$email_value = $plugin->getUserSetting("cpn_{$label}_email", $user->getGUID()); // grab the user setting that's been saved
	$site_value = $plugin->getUserSetting("cpn_{$label}_site", $user->getGUID());

	$e_chk_value = false;
	$s_chk_value = false;
	if ($email_value !== "{$label}_email_none")
		$e_chk_value = true;		

	if ($site_value !== "{$label}_site_none")
		$s_chk_value = true;
		
	$content .= '<div class="col-sm-8">' . elgg_echo("cp_notify:personal_{$label}").'</div>';
	$content .= '<div class="col-sm-2">' . elgg_view('input/checkbox', array('name'=>"params[cpn_{$label}_email]",'value'=>"{$label}_email",'default'=>"{$label}_email_none", 'checked'=>$e_chk_value, 'label'=>'Email',)).'</div>';
	$content .= '<div class="col-sm-2">' . elgg_view('input/checkbox', array('name'=>"params[cpn_{$label}_site]",'value'=>'{$label}_site','default'=>"{$label}_site_none", 'checked'=>$s_chk_value,'label'=>'Site',)).'</div>';
}

$content .= '</div>';


//Nick - Add colleague notifications area

$cpn_coll_notif_checkbox = elgg_view('input/checkboxes', array(
    'name' => "params[cpn_notif_{$user->getGUID()}]", //might need to pass something else here to get this to work
    'value'=>'test',
    'options'=>$cpn_notification_options,
    'multiple' => true,
    'checked'=>true,
    'class'=>' list-unstyled list-inline notif-ul',
    ));

$colleague_picker = elgg_view('input/friendspicker', array(
		'entities' => elgg_get_entities_from_relationship($options = [ 'relationship' => 'friend', 'relationship_guid' => $user->guid, ]),


	));

$content .='<div class="col-sm-12"><h3 class="well">Colleague Notification</h3>';
$content .= '<div class="col-sm-8">' . elgg_echo('cp_notify:colleagueContent').'</div>';
$content .= '<div class="col-sm-4">' . $cpn_coll_notif_checkbox.'</div>';
$content .= '<div class="accordion col-sm-12 clearfix mrgn-bttm-sm"> <div class="tgl-panel clearfix"><details class="acc-group"> <summary class="wb-toggle tgl-tab">'.elgg_echo('cp_notify:pickColleagues').'</summary>';
$content .='<div class="col-sm-12 clearfix">'. $colleague_picker.'</div>';
$content .= '</details></div></div>';
$content .= '</div>';
$content .= '<div class="col-sm-12 group-notification-options"><h3 class="well">Group Notification</h3></div>';
//This checkbox  is if you want to recieve emails about group notifications. it needs to toggle all the email check boxes
$content .= '<div class="col-sm-12 mrgn-bttm-md">'.elgg_view('input/checkbox', array('name' => "params[cpn_group_email_{$user->getGUID()}]", 'value'=>'', 'label'=>elgg_echo('cp_notify:emailsForGroup'), 'class'=>'all-email',)).'</div>';

$content .= '<div class="col-sm-12 mrgn-bttm-md">'.elgg_view('input/checkbox', array('name' => "params[cpn_group_site_{$user->getGUID()}]", 'value'=>'', 'label'=>elgg_echo('cp_notify:siteForGroup'), 'class'=>'all-site',)).'</div>';

$content .='<script>$(".all-email").click(function(){$(".group-check").prop("checked", this.checked);$(".group-check").trigger("change")})</script>'; //script to select all checked
$content .='<script>$(".all-site").click(function(){$(".group-site").prop("checked", this.checked);$(".group-site").trigger("change")})</script>'; //script to select all checked
//$content .='<script>$(".group-check").change(function(){cb =$(this); if(cb.val(0)){cb.val(1)}; if(cb.val(1)){cb.val(0)}})</script>';
foreach ($groups as $group) {
	$content .= "<div class='list-break clearfix'>";
    //Title stuff
	//$content .= "	<div class='namefield col-sm-6'>  </div>"; // column: name of the group
	//$content .= "	<div class='namefield col-sm-3'> <strong>".elgg_echo('cp_notify:email')."</strong> </div>"; // column: send notification by e-mail
	//$content .= "	<div class='namefield col-sm-3'> <strong>".elgg_echo('cp_notify:site_mail')."</strong> </div>"; // column: send notification by site mail

    //$email_check_box_input = get_input('cpn_email_'.$group->getGUID(), 'nothing');
    //error_log('cpn_email_'.$group->getGUID() .' '. $email_check_box_input);
    //Nick - this seems to deal with saving settings. It's asking for a string of subscribed or unsubscribe

	$cpn_set_subscription_email = $plugin->getUserSetting("cpn_email_{$group->getGUID()}", $user->getGUID());	// setting email notification

   //error_log($cpn_set_subscription_email .' Im the saved state');

	// (email) if user set item to subscribed, and no relationship has been built, please add new relationship
   if ($cpn_set_subscription_email == 'sub_'.$group->getGUID() /*&& !check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group->getGUID())*/){
		add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
  
   error_log('Im subbed! '.$group->getGUID());
    $cpn_grp_email_checked =true;
     }
	// (email) if user set item to unsubscribe, update relationship table
	if ($cpn_set_subscription_email == 'unSub' /*&& check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group->getGUID())*/){
		remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
    $cpn_grp_email_checked =false;
    error_log('No subs');
    }
	if (empty($cpn_set_subscription_email)) $cpn_set_subscription_email = 'sub_'.$group->getGUID() ;	// if not set, set no email as default



	$cpn_set_subscription_site_mail = $plugin->getUserSetting("cpn_site_mail_{$group->getGUID()}", $user->getGUID());
	// (site mail)
	if ($cpn_set_subscription_site_mail == 'sub_site_'.$group->getGUID()/* && !check_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail',$group->getGUID())*/){
        add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
        $cpn_grp_site_mail_checked =true;
    }
		
	// (site mail)
	if ($cpn_set_subscription_site_mail == 'site_unSub' /*&& check_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail',$group->getGUID())*/){
        remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
        $cpn_grp_site_mail_checked =false;
    }

	if (empty($cpn_set_subscription_site_mail)) $cpn_set_subscription_site_mail = 'sub_site_'.$group->getGUID();



	$options = array(
		'container_guid' => $group->guid,
		'type' => 'object',
		'limit' => false,
	);
	$group_contents = elgg_get_entities($options);

	$dropdown_options = array (	// labels for dropdown
		"subscribe" => elgg_echo("cp_notify:subscribe"),
		"unsubscribe" => elgg_echo("cp_notify:not_subscribed")
	);
    // Nick - setting variables for checked checkboxes and input values 
	if (check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID())){
		//$cpn_set_grp_subscription_email = elgg_echo("cp_notify:subscribe");
       //$cpn_set_grp_subscription_email = 0;
        //$cpn_grp_email_checked = 'checked';
       // error_log('I am subbed = '. $group->getGUID());
    }else{
		//$cpn_set_grp_subscription_email = elgg_echo("cp_notify:unsubscribe");
       //$cpn_set_grp_subscription_email = 1;
       // $cpn_grp_email_checked = '';
        //error_log('I am not subbed = '. $group->getGUID());
    }

	if (check_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID()))
		//$cpn_set_grp_subscription_site_mail = elgg_echo("cp_notify:subscribe");
        $cpn_set_grp_subscription_site_mail = 0;
	else
		//$cpn_set_grp_subscription_site_mail = elgg_echo("cp_notify:subscribe");
        $cpn_set_grp_subscription_site_mail = 1;

	// dropdown inputs (both email and site mail)
	$cpn_grp_email_input = elgg_view('input/dropdown', array(		// external email
		'name' => "params[cpn_email_{$group->getGUID()}]",
		'options_values' => $dropdown_options,
		'value' => $cpn_set_grp_subscription_email,
	));
    
//Nick - attempting the 'checkboxes' elgg way of doing things and gave up
    //$cpn_notification_grp_options = array('Email'=>$cpn_set_grp_subscription_email, 'Site'=>$cpn_set_grp_subscription_site_mail,);
   // $check_group_notif = array($cpn_set_grp_subscription_email, $cpn_set_grp_subscription_site_mail,);
    /*
    $cpn_grp_email_checkbox = elgg_view('input/checkboxes', array(
        'name' => "params[cpn_email_{$group->getGUID()}]",
        'value'=>$check_group_notif,
        'options'=>$cpn_notification_grp_options,
        'multiple' => true,
        'class'=>' list-unstyled list-inline notif-ul group-check',
        
        ));*/
/*
    $cpn_grp_email_checkbox = elgg_view('input/checkbox', array(
        'name' => "params[cpn_email_{$group->getGUID()}]",
        'value'=> $cpn_set_grp_subscription_email,
        'label'=>'Email',

        'class'=> 'group-check',
        ));*/

    $grp_email_name = "params[cpn_email_{$group->getGUID()}]"; //Nick - input names for checkboxes
    $grp_site_name ="params[cpn_site_mail_{$group->getGUID()}]";
    //Nick- this is some js that changes the value of the clicked on check box. It changes the value but elgg doesn't care about values :(

    //Nick -I just wrote my own checkboxes here. They get name, checked or nah, and the value (Subscribed or Unsubscribed)
   // $cpn_grp_email_checkbox = '<label><input class="group-check" type="checkbox" name="'.$grp_email_name .'" '.$cpn_grp_email_checked.' value="sub_'.$group->getGUID().'">Email</label>';

        $cpn_grp_email_checkbox = elgg_view('input/checkbox', array(
        'name' => "params[cpn_email_{$group->getGUID()}]",
        'value'=> 'sub_'.$group->getGUID(),
        'label'=>'Email',
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

    //$cpn_grp_site_checkbox = '<label><input class="group-check" type="checkbox" name="'.$grp_site_name.'" '.$cpn_grp_site_cked.' value="'.$cpn_set_grp_subscription_site_mail.'">Site</label>';
    
    //Nick- this isn't used
	$cpn_grp_site_mail_input = elgg_view('input/dropdown', array( 	// internal email
		'name' => "params[cpn_site_mail_{$group->getGUID()}]",
		'options_values' => $dropdown_options,
		'value' => $cpn_set_grp_subscription_site_mail,
	));

	// GROUP CONTENT SUBSCRIPTIONS
	$content .= "<div class=' '>";
	$content .= "<div class='namefield col-sm-8'> <strong> <a href='{$group->getURL()}' id='group-{$group->guid}'>{$group->name}</a> </strong> </div>";
	//$content .= "<div class='togglefield col-sm-3'> {$cpn_grp_email_input} </div>";
	//$content .= "<div class='togglefield col-sm-3'> {$cpn_grp_site_mail_input} </div>";
    $content .= '<div class="col-sm-2">'.$cpn_grp_email_checkbox.'</div>'; //Nick - Here are the group checkboxes
    $content .= '<div class="col-sm-2">'.$cpn_grp_site_checkbox.'</div>';
	$content .= "</div>";
    //Nick - Accordion for group content
    $content .= '<div class="accordion col-sm-12 clearfix mrgn-bttm-sm"><details class="acc-group"> <summary class="wb-toggle tgl-tab">'.elgg_echo('cp_notify:groupContent').'</summary>';
    $content .= '<div class="tgl-panel clearfix">';
    $content .= '<div>' ;
   // $content .= '<div class="col-sm-12">'.elgg_view('input/checkbox', array('name' => "params[cpn_group_newCont_{$group->getGUID()}]", 'value'=>'test', 'label'=>elgg_echo('cp_notify:notifNewContent'),)).'</div>';
  //  $content .= '<div class="col-sm-12">'.elgg_view('input/checkbox', array('name' => "params[cpn_group_comment_{$group->getGUID()}]", 'value'=>'test', 'label'=>elgg_echo('cp_notify:notifComments'),)).'</div>';
    $content.= '</div>';
	$cp_table_tr_count = 0;
    //Nick - Group content that user is subscribed to goes here in the accordion
	foreach ($group_contents as $group_content) {
		if (!in_array($group_content->getSubtype(), $no_notification_available)) {
			$cp_table_tr_count++;	// so we can display a message when the user does not have anything subscribed to
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

			// dropdown inputs (both email and site mail)
			$cpn_email_input = elgg_view('input/dropdown', array(
				'name' => "params[cpn_email_{$group_content->getGUID()}]",
				'options_values' => $dropdown_options,
				'value' => $cpn_set_subscription_email,
			));

            $cpn_unsub_btn = elgg_view('input/button', array(
                'src'=>'#', //put the unsub action to the object here
                'class'=>'btn btn-default unsub-button',
                'id'=>$group_content->getGUID() .'_b',
                'value'=> elgg_echo("cp_notify:unsubscribe"),
            ));

			$cpn_site_mail_input = elgg_view('input/dropdown', array(	// TODO: implement site-mail notifications
				'name' => "params[cpn_site_mail_{$group_content->getGUID()}]",
				'options_values' => $dropdown_options,
				'value' => $cpn_set_subscription_site_mail,
			));
            if(check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group_content->getGUID())){
            //Nick - only display group content the user is subscribed to.
            
			$content .= "<div class='clearfix col-sm-12 list-break'>";
			$content .= "<div class='togglefield col-sm-10'> <a href='{$group_content->getURL()}'> {$group_content->title} </a> <br/><sup>{$group_content->getSubtype()}</sup> </div>";	// column: content name
			$content .= "<div class=' col-sm-2'> ".$cpn_unsub_btn." </div>";	// column: send by e-mail
			//$content .= "<div class='togglefield col-sm-3'> {$cpn_site_mail_input} </div>";	// column: send by site-mail
            $content .= "</div>";
            }
            
		} // end if
	} // end foreach loop
    $content .= '</div></div></details></div>';
	
	//$content .= "<div> <div class='spacercolumn' colspan='3'>&nbsp;</div> </div>";
}

if ($cp_table_tr_count <= 0)
	//$content .= "<div><div colspan='3'>".elgg_echo('cp_notify:no_group_sub')."</div></div>";
$content .= "</section>";






// CONTENT SUBSCRIBED BY OTHER USERS
$options = array(
	'relationship' => 'cp_subscribed_to_email',
	'relationship_guid' => $user->guid,
	'inverse_relationship' => false,
	'limit' => 0	// no limit
);
$interested_contents = elgg_get_entities_from_relationship($options);

$cp_table_tr_count = 0;
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%'>";
$content .= "<div>";
$content .= "	<div class='namefield col-sm-6'> <strong> Subscribed Content </strong> </div>"; // column: name of the group
$content .= "	<div class='namefield col-sm-3'> <strong> E-mail </strong> </div>"; // column: send notification by e-mail
$content .= "	<div class='namefield col-sm-3'> <strong> Site-mail </strong> </div>"; // column: send notification by site mail
$content .= "</div>";
foreach ($interested_contents as $interested_content) {
	if ($interested_content->owner_guid != $user->guid && !in_array($interested_content->getSubtype(), $no_notification_available) && $interested_content->title && $interested_content->getType() === 'object') {
		$cp_table_tr_count++;

		$cpn_set_subscription_email = $plugin->getUserSetting("cpn_email_{$interested_content->getGUID()}", $user->getGUID());	// setting email notification
		
		// if user set item to subscribed, and no relationship has been built, please add new relationship
		if ($cpn_set_subscription_email === elgg_echo("cp_notify:subscribe") && !check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$interested_content->getGUID()))
			add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $interested_content->getGUID());
		// if user set item to unsubscribe, update relationship table
		if ($cpn_set_subscription_email === elgg_echo("cp_notify:unsubscribe") && check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$interested_content->getGUID()))
			remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $interested_content->getGUID());

		if (empty($cpn_set_subscription_email)) $cpn_set_subscription_email = elgg_echo("cp_notify:unsubscribe");	// if not set, set no email as default

		$cpn_set_subscription_site_mail = $plugin->getUserSetting("cpn_site_mail_{$interested_content->getGUID()}", elgg_get_page_owner_guid());
		if (empty($cpn_set_subscription_site_mail)) $cpn_set_subscription_site_mail = elgg_echo("cp_notify:unsubscribe");


		// dropdown inputs (both email and site mail)
		$cpn_email_input = elgg_view('input/dropdown', array(
			'name' => "params[cpn_email_{$interested_content->getGUID()}]",
			'options_values' => $dropdown_options,
			'value' => $cpn_set_subscription_email,
		));

		$cpn_site_mail_input = elgg_view('input/dropdown', array(	// TODO: implement site-mail notifications
			'name' => "params[cpn_site_mail_{$interested_content->getGUID()}]",
			'options_values' => $dropdown_options,
			'value' => $cpn_set_subscription_site_mail,
		));
        /* Nick Temp comment 
		$content_owner = get_user($interested_content->owner_guid);
		$content .= "<div>";
		$content .= "<div class='namefield col-sm-6'> <a href='{$interested_content->getURL()}'>{$interested_content->title}</a> <br/><sup> Author: {$content_owner->name} / {$interested_content->getSubtype()} </sup> </div>";
		$content .= "<div class='togglefield col-sm-3'> {$cpn_email_input} </div>";
		$content .= "<div class='togglefield col-sm-3'> {$cpn_site_mail_input} </div>";
		$content .= "</div>";*/
	}
}

if ($cp_table_tr_count <= 0)
	$content .= "<div><td colspan='3'>You have not subscribed to any content.</td></div>";
$content .= "</section>";



echo elgg_extend_view('page/elements/sidebar','cp_notifications/sidebar');
echo elgg_view_module('info', $title, $content);


