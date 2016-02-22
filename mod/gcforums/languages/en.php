<?php
$site_url = elgg_get_site_url();
$english = array(

	"gcforums:group_forum_title" => "[en] Group Forum",
	"gcforums:forum_edit" => "[en] Edit Forum",
	"gcforums:forum_delete" => "[en] Delete Forum",
	"gcforums:forum_title" => "[en] Forum",
	"gcforums:group_nav_label" => "[en] Group Forums",

	"gcforums:posted_on" => "[en] Posted on: %s",

	"gcforums:edit" => "[en] Edit",
	"gcforums:delete" => "[en] Delete",
	"gcforums:create" => "[en] Create",

	"gcforums:submit" => "[en] Submit",

	"gcforums:topics" => "[en] Topics",
	"gcforums:forums" => "[en] Forums",
	"gcforums:posts" => "[en] Posts",
	"gcforums:latest" => "[en] Latest",

	"gcforums:topic_starter" => "[en] Topic Starter",
	"gcforums:replies" => "[en] Replies",
	"gcforums:last_posted" => "[en] Last Posted",

	
	// this was a mistake, (posting is inverse)
	"gcforums:enable_posting_label" => "[en] Disable Posting",

	"gcforums:title_label_hjforumcategory" => "[en] Category Name",
	"gcforums:title_label_hjforum" => "[en] Forum Name",
	"gcforums:title_label_hjforumtopic" => "[en] Topic Name",
	"gcforums:new_hjforumcategory" => "[en] New Category",
	"gcforums:description" => "[en] Description",
	"gcforums:topic_reply" => "[en] Reply",
	"gcforums:access_label" => "[en] Access/Visibility",
	"gcforums:enable_categories_label" => "[en] Enable Subcategories",
	"gcforums:file_under_category_label" => "[en] File under Category",
	"gcforums:new_hjforum" => "[en] New Forum",
	"gcforums:new_hjforumtopic" => "[en] New Forum Topic",
	"gcforums:new_hjforumcategory" => "[en] New Category",
	"gcforums:edit_hjforum" => "[en] Edit Forum",
	"gcforums:delete_hjforumtopic" => "[en] Delete Forum",


	"gcforums:total_topics" => "[en] Total Topics",
	"gcforums:total_posts" => "[en] Total Posts",
	"gcforums:latest_posts" => "[en] Latest Posts",

	"gcforums:no_posts" => "[en] None",
	"gcforums:sticky_topic" => "[en] Sticky Topics",

	"gcforums:forums_not_available" => "[en] <i>Currently No Forums Available</i>",
	"gcforums:topics_not_available" => "[en] <i>Currently No Topics Available</i>",
	"gcforums:no_comments" => "[en] <i>No comments have been made yet... Be the first!</i>",
	"gcforums:categories_not_available" => "[en] <i>Currently No Categories Available</i>",

	"gcforums:jmp_menu" => "[en] Jobs Marketplace",
	//"gcforums:jmp_url" => "http://jmp.com",
    "gcforums:jmp_url" => $site_url . "groups/profile/7617072",

	"gcforums:notification_subject_topic" => "New forum topic / Nouveau sujet",
	"gcforums:notification_body_topic" => "%s has started a New Forum Topic '%s' with the following content... <br/> %s <br/> You can view this item here: %s <br/>",

	"gcforums:notification_subject_post" => "New forum post / Nouveau post sur le forum",
	"gcforums:notification_body_post" => "%s made a reply in the Forum Topic '%s' with the following content... <br/> %s <br/> You can view this item here: %s <br/>",

	);

add_translation("en", $english);