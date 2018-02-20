<?php

namespace Beck24\MemberSelfDelete;

// get our inputs
$offset = get_input('offset', 0);
if ($offset < 0) {
	$offset = 0;
}
$limit = get_input('limit', 10);

// get total for pagination
$params = array(
	'guid' => elgg_get_site_entity()->guid,
	'annotation_names' => array('selfdeletefeedback'),
	'no_results' => elgg_echo('member_selfdelete:feedback:no_results')
);


echo elgg_list_annotations($params);
