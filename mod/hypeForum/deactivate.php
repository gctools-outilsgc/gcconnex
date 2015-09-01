<?php

$subtypes = array(
	'hjforum' => 'hjForum',
	'hjforumtopic' => 'hjForumTopic',
	'hjforumpost' => 'hjForumPost',
	'hjforumcategory' => 'hjForumCategory'
);

foreach ($subtypes as $subtype => $class) {
	update_subtype('object', $subtype);
}
