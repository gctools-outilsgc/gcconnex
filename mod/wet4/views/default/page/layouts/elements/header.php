<?php
/**
 * header.php
 *
 * Header for layouts
 *
 * @uses $vars['title']  Title
 * @uses $vars['header'] Optional override for the header
 *
 * @package wet4
 * @author GCTools Team

 2015/10/15-
 Removed page header from group profile page
 Styled buttons
 */

//check what page we are on
$checkPage = elgg_get_context();

if (isset($vars['header'])) {
	echo '<div class="elgg-head clearfix">';
	echo $vars['header'];
	echo '</div>';
	return;
}

$title = elgg_extract('title', $vars, '');

$buttons = elgg_view_menu('title', array(
	'sort_by' => 'priority',
	'class' => 'list-inline pull-right',
    'item_class' => '',
));

if ($title || $buttons) {

    //do not display main heading on discussion page
    if($checkPage == 'group_profile'){

    } else if(elgg_in_context('dept_activity')){
				echo '<h1 style="border-bottom:none;" class="panel-title mrgn-bttm-sm mrgn-tp-sm mrgn-lft-md">'.$title.'</h1>';
		} else {
        // @todo .elgg-heading-main supports action buttons - maybe rename class name?
        if($checkPage != 'view_file') {
            $buttons2 = elgg_view_menu('title2', array(
            'sort_by' => 'priority',
            'class' => 'list-inline mrgn-rght-sm',
            ));
        }
        if($checkPage == 'messages') {
            $notificationSettings = elgg_echo('cp_notifications:name');

            $user_object = elgg_get_logged_in_user_entity();
            $username = $user_object->username;

            $notificationsSettingLink =  elgg_get_site_url() . "settings/notifications/{$username}";
            
            $notificationSettingsBtn = "<ul class=\"elgg-menu elgg-menu-title list-inline pull-right elgg-menu-title-default\" style=\"padding-left: 5px\"><li class=\"elgg-menu-item-add\"><a href=\"{$notificationsSettingLink}\" class=\"elgg-menu-content btn btn-default btn-md\">{$notificationSettings}</a></li></ul>";
        }
        if(elgg_get_page_owner_entity()){
            if(elgg_get_page_owner_entity()->getType() == 'group'){
                $buttons = elgg_view_menu('title', array(
                'sort_by' => 'priority',
                'class' => 'list-inline',
                ));

                echo elgg_view('groups/profile/summaryBlock', $vars);
                elgg_push_context('groupSubPage');
                echo elgg_view('groups/profile/tab_menu');
                elgg_pop_context();
            }
        }
        $format_title = elgg_view_title($vars['title'], array('class' => 'elgg-heading-main mrgn-lft-sm'));
        echo elgg_format_element('div', ['class' => 'd-flex title-button-combo'], $format_title .'<div class="title-action-button d-flex">' . $buttons2 . $buttons . $notificationSettingsBtn . '</div>');
    }
}
