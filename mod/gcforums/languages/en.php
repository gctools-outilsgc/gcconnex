<?php
$site_url = elgg_get_site_url();
$english = array(

	'gcforums:notfound' => "Page not found",

	'river:create:object:hjforumtopic' => "%s created a forum topic %s",
	'gcforums:delete:heading' => "Deletion confirmation",
	'gcforums:delete:body' => "Are you sure you want to delete the %s",
	'gcforums:delete:cancel' => "Cancel",
	'gcforums:delete:delete' => "Delete",
	'gcforums:edit:new_forum:heading' => "New %s",
	'gcforums:edit:edit_forum:heading' => "Edit %s",

	'gcforums:user:name' => "Name (username):",
	'gcforums:user:email' => "Email:",
	'gcforums:user:posting' => "Posting:",

	'gcforums:delete:success' => "'%s' has been deleted successfully",
	'gcforums:delete:nosuccess' => "'%s' could not be deleted",
	'gcforums:saved:success' => "'%s' has been saved successfully",

	'gcforums:translate:subscribe' => "Subscribe",
	'gcforums:translate:unsubscribe' => "Unsubscribe",

	'gcforums:translate:hjforumcategory' => "Category",
	'gcforums:translate:hjforum' => "Forum",
	'gcforums:translate:hjforumtopic' => "Topic",
	'gcforums:translate:hjforumpost' => "Post",

	'gcforums:translate:edit' => "Edit",
	'gcforums:translate:delete' => "Delete",
	'gcforums:translate:new_topic' => "New forum topic",
	'gcforums:translate:new_subforum' => "New subforum",
	'gcforums:translate:new_subcategory' => "New category",

	'gcforums:label:title' => "Title",

	'gcforum:heading:default_title' => "Group Forums",

	"gcforums:translate:topics" => "topics",
	"gcforums:translate:forums" => "forums",
	"gcforums:translate:posts" => "posts",
	"gcforums:translate:latest" => "latest",

	"gcforums:translate:topic_starter" => "Topic Starter",
	"gcforums:translate:replies" => "Replies",
	"gcforums:translate:last_posted" => "Last post",

	"gcforums:translate:total_topics" => "Total topics",
	"gcforums:translate:total_replies" => "Total replies",
	"gcforums:translate:latest_posts" => "Latest post",

	"gcforums:is_sticky" => 'Sticky topic',
	"gcforums:forumpost_saved" => "Your reply has been created successfully",
	"gcforums:forumtopic_saved" => "Your Forum Topic '%s' has been created successfully",
	"gcforums:forumcategory_saved" => "The Forum Category has been created successfully",
	"gcforums:forum_saved" => "The Forum has been created successfully",

	"gcforums:forumpost_failed" => "Your reply has not been created successfully",
	"gcforums:forumtopic_failed" => "Your topic '%s' has not been created successfully",
	"gcforums:forum_failed" => "The Forum has not been created successfully",

	"gcforums:gobacktomain" => "Go back to Main",
	"gcforums:categories_requred" => "Please create categories before creating new Forum",

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

	"gcforums:no_posts" => "None",
	"gcforums:sticky_topic" => "Sticky Topics",

	"gcforums:forums_not_available" => "<i>Currently No Forums Available</i>",
	"gcforums:topics_not_available" => "<i>Currently No Topics Available</i>",
	"gcforums:no_comments" => "<i>No comments have been made yet... Be the first!</i>",
	"gcforums:categories_not_available" => "<i>Currently No Categories Available</i>",

	"gcforums:jmp_menu" => "Career Marketplace",
	"gcforums:jmp_url" => $site_url . "groups/profile/7617072",

	"gcforums:notification_subject_topic" => "New forum topic",
	"gcforums:notification_body_topic" => "%s has started a New Forum Topic '%s' with the following content... <br/> %s <br/> You can view this item here: %s <br/>",

	"gcforums:notification_subject_post" => "New forum post",
	"gcforums:notification_body_post" => "%s made a reply in the Forum Topic '%s' with the following content... <br/> %s <br/> You can view this item here: %s <br/>",

	//edit page

	'gforums:title_label' => "Forum Name",
	'gforums:description_label' => "Description",
	'gcforums:save_button' => "Save",

	'gcforums:subscribe' => 'Subscribe',
	'gcforums:unsubscribe' => 'Unsubscribe',

	'gcforums:missing_description' => 'Missing Description',
);

add_translation("en", $english);
