<?php

// development purposes (not intended for production)

$user_guid = 127; // sokguan

$options = array(
	'container_guid' => $group->guid,
	'type' => 'object',
	'limit' => false,
);
$grp_items = elgg_get_entities($options);

foreach ($grp_items as $grp->item) {
	$cpn_set_subscription_site_mail = $plugin->getUserSetting("cpn_site_mail_{$grp_item->getGUID()}", $user_guid);
	echo "cpn_set_sub: {$cpn_set_subscription_site_mail}";
}