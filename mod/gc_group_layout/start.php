<?php

/*
* GC Group Layout - modifies the group layout
*
* @version 1.0
* @author Nick
*/
//Init
elgg_register_event_handler('init','system','gc_group_layout_init');

//Register Handler for owner_block



function gc_group_layout_init(){

    elgg_register_library('elgg:groups', elgg_get_plugins_path() . 'gc_group_layout/lib/groups.php');
// Extend the sidebar to have the full length group anchor header
    elgg_extend_view('page/layouts/one_sidebar', 'groups/profile/summary', 420);

    elgg_extend_view('page/layouts/one_sidebar', 'page/elements/cover_photo', 400);
    elgg_extend_view('css/elgg', 'css/group_layout');

    elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'group_owners_block_handler');

    elgg_register_ajax_view('ajax/grp_ajax_content');
    elgg_extend_view("js/elgg", "js/group_ajax");

}

  elgg_register_page_handler('c_photo_image', 'c_photo_page_handler');

function group_owners_block_handler($hook, $type, $menu, $params){
/***TEMP ***/


    //rearrange menu items
    if(elgg_get_context() == 'group_profile'){

        elgg_unregister_menu_item('owner_block', 'Activity');

        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){

            switch ($item->getName()) {


				case 'discussion':
					// cyu - take discussions off for the crawler
					if (strcmp('gsa-crawler',strtolower($_SERVER['HTTP_USER_AGENT'])) != 0) {
						$item->setText(elgg_echo('gprofile:discussion'));
						$item->setHref('#groupforumtopic');
						$item->setPriority('1');
					}
                    break;


                case 'gcforums':
                    $item->setPriority('1');
                    $item->setLinkClass('forums');
                    break;
                case 'related_groups':
                    $item->setHref('#related');

                    $item->setPriority('20');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));
                    $item->setHref('#file');
                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));
                    $item->setHref('#blog');
                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));
                    $item->setHref('#calendar');
                    $item->setPriority('5');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));
                    $item->setHref('#page_top');
                    $item->setPriority('6');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));
                    $item->setHref('#bookmarks');
                    $item->setPriority('7');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));
                    $item->setHref('#polls');
                    $item->setPriority('14');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));
                    $item->setHref('#taks');
                    $item->setPriority('9');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->setHref('#albums');
                    $item->addItemClass('removeMe');
                    $item->setPriority('10');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));
                    if(get_language() == 'en'){
                        $item->setHref('#albums');
                    } else {
                        $item->setHref('#albums');
                    }
                    $item->setPriority('11');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));
                    $item->setHref('#ideas');
                    $item->setPriority('12');
                    break;
                case 'activity':
                    elgg_unregister_menu_item('owner_block', 'activity');
                    $item->setText('Activity');
                    $item->setHref('#activity');
                    $item->setPriority('8');
                    break;

            }

        }


    }


    //rearrange menu items
    if(elgg_get_context() == 'groupSubPage'){

        elgg_unregister_menu_item('owner_block', 'activity');

        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){

            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));

                    $item->setPriority('1');
                    break;
                case 'gcforums':
                    $item->setPriority('1');
                    $item->setLinkClass('forums');
                    break;
                case 'related_groups':


                    $item->setPriority('20');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));

                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));

                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));

                    $item->setPriority('5');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));

                    $item->setPriority('6');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));

                    $item->setPriority('7');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));

                    $item->setPriority('8');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));

                    $item->setPriority('9');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('10');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));

                    $item->setPriority('11');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));

                    $item->setPriority('12');
                    break;
                case 'activity':
                    $item->setText('Activity');

                    $item->setPriority('13');
                    $item->addItemClass('removeMe');
                    break;

            }

        }
    }

}


function c_photo_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/c_photo_image.php");
    return true;
}
