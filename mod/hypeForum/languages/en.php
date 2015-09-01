<?php

$english = array(

	'forums:jmp_menu' => 'Jobs Marketplace',
	'forums:jmp_url' => '/forum/group/42',
	'edit:object:hjforum:disable_posting' => 'Disable posting in this forum',
	
	'c_hj:forum:new:hjforum' => 'New sub-forum / Nouveau sous-forum',
	'c_hj:forum:new:hjforumtopic' => 'New forum topic / Nouveau sujet',
	'c_hj:forum:new:hjforumpost' => 'New forum post / Nouveau post sur le forum',

	'c_hj:forum:body:hjforumtopic' => "
	%s has started a new forum topic <strong>%s</strong> located in [ <i>%s</i> ] with the following content:%s
	You can view this item %s.

	<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a lancé un nouveau sujet sur le forum <strong>%s</strong> dans [ <i>%s</i> ] avec le contenu suivant :%s
	Vous pouvez consulter cet article %s.
	",

	'c_hj:forum:body:hjforum' => "
	%s has started a new sub-forum <strong>%s</strong> located in [ <i>%s</i> ] with the following content:%s
	You can view this item %s.

	<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a lancé un nouveau sous-forum sur le forum <strong>%s</strong> dans [ <i>%s</i> ] avec le contenu suivant :%s
	Vous pouvez consulter cet article %s.
	",

	'c_hj:forum:body:hjforumpost' => "
	%s has started a new forum post <strong>%s</strong> located in [ <i>%s</i> ] with the following content:%s
	You can view this item %s.

	<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a lancé un nouveau post sur le forum <strong>%s</strong> dans [ <i>%s</i> ] avec le contenu suivant :%s
	Vous pouvez consulter cet article %s.
	",

	'hj:forum:nocategories' => 'You have not yet setup any categories. Please do so, using the form below',

	'c_hj:forum:nocategories' => "Since there are no categories set up, the forums will not be displayed. Please create a new category by selecting the 'New forum category'.",

    'forum' => 'Forum',
	'forums' => 'Forums',
	'hj:forum:siteforums' => 'Site-wide Forums',
	
	'item:object:hjforum' => 'Forums',
	'item:object:hjforumtopic' => 'Forum Topics',
	'item:object:hjforumpost' => 'Forum Posts',
	'item:object:hjforumcategory' => 'Forum Category',
	
	'items:object:hjforum' => 'forums',
	'items:object:hjforumtopic' => 'forum topics',
	'items:object:hjforumpost' => 'forum posts',
	'items:object:hjforumcategory' => 'forum categories',
	
	// Form Elements
	'edit:object:hjforum:cover' => 'Cover Image',
	'edit:object:hjforum:title' => 'Forum Title',
	'edit:object:hjforum:description' => 'Subtitle',
	'edit:object:hjforum:access_id' => 'Visibility',
	'edit:object:hjforum:category' => 'Category',
	'edit:object:hjforum:enable_subcategories' => 'Enable subcategories',

	'edit:object:hjforumtopic:cover' => 'Cover',
	'edit:object:hjforumtopic:icon' => 'Icon',
	'edit:object:hjforumtopic:title' => 'Title',
	'edit:object:hjforumtopic:description' => 'Description',
	'edit:object:hjforumtopic:category' => 'Category',
	'edit:object:hjforumtopic:access_id' => 'Visibility',
	

	'hj:forum:tablecol:forum' => '',
	'hj:forum:tablecol:topics' => 'Topics',
	'hj:forum:tablecol:posts' => 'Posts',
	'hj:forum:tablecol:last_post' => 'Latest Post',

	'river:in:forum' => ' in %s',
	'river:create:object:hjforum' => '%s created a new forum | %s',
	'river:create:object:hjforumtopic' => '%s started a new forum topic | %s',
	'river:create:object:hjforumpost' => '%s posted a reply to topic %s',
	
	'edit:object:hjforumcategory:title' => 'Category Name',
	'edit:object:hjforumcategory:description' => 'Brief Description',

	'edit:object:hjforumpost:description' => 'Reply',
	
	'hj:forum:notsetup' => 'This forum has not yet been configured',

	'hj:forum:create:forum' => 'New forum',
	'hj:forum:create:subforum' => 'New sub-forum',
	'hj:forum:create:topic' => 'New posting',
	'hj:forum:create:post' => 'Reply',
	'hj:forum:create:post:quote' => 'Quote & Reply',
	'hj:forum:create:category' => 'New forum category',

	'hj:forum:dashboard:site' => 'Site-wide Forums',
	'hj:forum:dashboard:groups' => 'Group Forums',
	'hj:forum:dashboard:bookmarks' => 'Bookmarked Forum Topics',
	'hj:forum:dashboard:subscriptions' => 'Forum Subscriptions',

	'hj:forum:dashboard:tabs:site' => 'Site-wide Forums',
	'hj:forum:dashboard:tabs:groups' => 'Group Forums',
	'hj:forum:dashboard:tabs:bookmarks' => 'Bookmarks',
	'hj:forum:dashboard:tabs:subscriptions' => 'Subscription',

	'edit:plugin:hypeforum:params[categories_top]' => 'Enable categories for top-level Site and Group forums',
	'edit:plugin:hypeforum:hint:categories_top' => 'Enabling this option will allow you to create multiple top-level categories, and forums will be grouped by category',

	'edit:plugin:hypeforum:params[categories]' => 'Enable categories for nested forums and topics',
	'edit:plugin:hypeforum:hint:categories' => 'Enabling this option will allow you to toggle categories within individual forums; sub-forums and topics will be grouped by category',

	'edit:plugin:hypeforum:params[subforums]' => 'Enable sub-forums',
	'edit:plugin:hypeforum:hint:subforums' => 'Enabling this option will allow you to create forums within forums; by default, items will be ordered as follows: sub-forums followed by sticky topics followed by regular topics by latest post)',

	'edit:plugin:hypeforum:params[forum_cover]' => 'Enable cover images for forums',
	'edit:plugin:hypeforum:hint:forum_cover' => 'If enabled, forum authors will be able to add cover images, which will be used both as icons and displayed as a cover image in full forum view',
	
	'edit:plugin:hypeforum:params[forum_sticky]' => 'Enable sticky topics',
	'edit:plugin:hypeforum:hint:forum_sticky' => 'In default list ordering, sticky forms will be displayed first; they will also be marked with an icon',

	'edit:plugin:hypeforum:params[forum_topic_cover]' => 'Enable cover images for topics',
	'edit:plugin:hypeforum:hint:forum_topic_cover' => 'If enabled, topic authors will be allowed to add cover images to their topics',

	'edit:plugin:hypeforum:params[forum_topic_icon]' => 'Enable topic icons',
	'edit:plugin:hypeforum:hint:forum_topic_icon' => 'If enabled, topic authors will be able to choose an icon for their topic (see options below for a list of icons)',

	'edit:plugin:hypeforum:params[forum_topic_icon_types]' => 'List of topic icon types',
	'edit:plugin:hypeforum:topic_icon_hint' => 'Separated by comma. Icons need to be uploaded into mod/hypeForum/graphics/forumtopic/',

	'edit:plugin:hypeforum:params[forum_forum_river]' => 'Add new forums to river',
	'edit:plugin:hypeforum:hint:forum_forum_river' => 'Add information about new forums to the activity stream',

	'edit:plugin:hypeforum:params[forum_topic_river]' => 'Add new topics to river',
	'edit:plugin:hypeforum:hint:forum_forum_river' => 'Add information about new forum topics to the activity stream',

	'edit:plugin:hypeforum:params[forum_post_river]' => 'Add new posts to river',
	'edit:plugin:hypeforum:hint:forum_forum_river' => 'Add information about new forum posts to the activity stream',

	'edit:plugin:hypeforum:params[forum_subscriptions]' => 'Enable notification subscriptions',
	'edit:plugin:hypeforum:hint:forum_subscriptions' => 'Enabling this option will allow users to subscribe/unscribe from forum topic notifications',

	'edit:plugin:hypeforum:params[forum_bookmarks]' => 'Enable bookmarks',
	'edit:plugin:hypeforum:hint:forum_bookmarks' => 'Enabling this option will allow users to bookmark forum topics and display them in a separate tab on dashboard',

	'edit:plugin:hypeforum:params[forum_group_forums]' => 'Enable Group forums',
	'edit:plugin:hypeforum:hint:forum_group_forums' => 'Add forum functionality to groups',

	'edit:plugin:hypeforum:params[forum_user_signature]' => 'Enable user signatures in forum posts',
	'edit:plugin:hypeforum:hint:forum_user_signature' => 'Allows users to create an automatic signature and append it to all their posts; a forum to add a signature will be available in users\' tool settings',
	
	'hj:forum:filter' => 'Filter Forums',

	'hj:forum:quote:author' => '%s wrote:',

	'hj:forum:groups:notamember' => 'You have not joined any group yet',

	'hj:forum:groupoption:enableforum' => 'Enable group forums',
	'hj:forum:group' => 'Group forums',

	'hj:forum:dashboard:group' => '%s',

	'edit:object:hjforum:sticky' => 'Sticky Topic',
	'hj:forum:sticky' => 'Sticky Topic',

	'hj:forum:new:hjforum' => 'A new sub-forum',
	'hj:forum:new:hjforumtopic' => 'A new forum topic',
	'hj:forum:new:hjforumpost' => 'A new forum post',

	'hj:forum:user:settings' => 'Forum Settings',

	'edit:plugin:user:hypeforum:params[hypeforum_signature]' => 'Add signature to my forum posts:',

	'hj:forum:bookmark:create' => 'Bookmark',
	'hj:forum:bookmark:remove' => 'Remove Bookmark',
	'hj:forum:bookmark:create:error' => 'Item can not be bookmarked',
	'hj:forum:bookmark:create:success' => 'Item successfully bookmarked',
	'hj:forum:bookmark:remove:error' => 'Bookmark can not be removed',
	'hj:forum:bookmark:remove:success' => 'Bookmark successfully removed',

	'hj:forum:subscription:create' => 'Subscribe',
	'hj:forum:subscription:remove' => 'Unsubscribe',
	'hj:forum:subscription:create:error' => 'You can\'t subscribe to this item',
	'hj:forum:subscription:create:success' => 'You are now subscribed to this item',
	'hj:forum:subscription:remove:error' => 'Can not unsubscribe from this item',
	'hj:forum:subscription:remove:success' => 'You are no longer subscribed to this item',
	
	
);


add_translation("en", $english);
?>