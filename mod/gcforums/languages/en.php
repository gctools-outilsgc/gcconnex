<?php
$site_url = elgg_get_site_url();
$english = array(

	"gcforums:group_forum_title" => "Group Forum",
	"gcforums:forum_edit" => "Edit Forum",
	"gcforums:forum_delete" => "Delete Forum",
	"gcforums:forum_title" => "Forum",
	"gcforums:group_nav_label" => "Group Forums",

	"gcforums:posted_on" => "Posted on: %s",

	"gcforums:edit" => "Edit",
	"gcforums:delete" => "Delete",
	"gcforums:create" => "Create",

	"gcforums:submit" => "Submit",

	"gcforums:topics" => "Topics",
	"gcforums:forums" => "Forums",
	"gcforums:posts" => "Posts",
	"gcforums:latest" => "Latest",

	"gcforums:topic_starter" => "Topic Starter",
	"gcforums:replies" => "Replies",
	"gcforums:last_posted" => "Last Posted",

	
	// this was a mistake, (posting is inverse)
	"gcforums:enable_posting_label" => "Disable Posting",

	"gcforums:title_label_hjforumcategory" => "Category Name",
	"gcforums:title_label_hjforum" => "Forum Name",
	"gcforums:title_label_hjforumtopic" => "Topic Name",
	"gcforums:new_hjforumcategory" => "New Category",
	"gcforums:description" => "Description",
	"gcforums:topic_reply" => "Reply",
	"gcforums:access_label" => "Access/Visibility",
	"gcforums:enable_categories_label" => "Enable Subcategories",
	"gcforums:file_under_category_label" => "File under Category",
	"gcforums:new_hjforum" => "New Forum",
	"gcforums:new_hjforumtopic" => "New Forum Topic",
	"gcforums:new_hjforumcategory" => "New Category",
	"gcforums:edit_hjforum" => "Edit Forum",
	"gcforums:delete_hjforumtopic" => "Delete Forum",


	"gcforums:total_topics" => "Total Topics",
	"gcforums:total_posts" => "Total Posts",
	"gcforums:latest_posts" => "Latest Posts",

	"gcforums:no_posts" => "None",
	"gcforums:sticky_topic" => "Sticky Topics",

	"gcforums:forums_not_available" => "<i>Currently No Forums Available</i>",
	"gcforums:topics_not_available" => "<i>Currently No Topics Available</i>",
	"gcforums:no_comments" => "<i>No comments have been made yet... Be the first!</i>",
	"gcforums:categories_not_available" => "<i>Currently No Categories Available</i>",

	"gcforums:jmp_menu" => "Jobs Marketplace",
	//"gcforums:jmp_url" => "http://jmp.com",
    "gcforums:jmp_url" => $site_url . "groups/profile/7617072",

	"gcforums:notification_subject_topic" => "New forum topic",
	"gcforums:notification_body_topic" => "%s has started a New Forum Topic '%s' with the following content... <br/> %s <br/> You can view this item here: %s <br/>",

	"gcforums:notification_subject_post" => "New forum post",
	"gcforums:notification_body_post" => "%s made a reply in the Forum Topic '%s' with the following content... <br/> %s <br/> You can view this item here: %s <br/>",
    'gcforums:time'=>'on',

	);

add_translation("en", $english);