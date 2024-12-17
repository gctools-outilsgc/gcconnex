<?php

function discussion_menu_entity_hook($hook, $type, $return_value, $params) {
	$result = $return_value;

	if (!empty($params) && is_array($params)) {
		$entity = elgg_extract("entity", $params);

        if (elgg_instanceof($entity, "object", "groupforumtopic") && $entity->canEdit()) {
            $result[] = ElggMenuItem::factory(array(
                "name" => "download_full_discussion",
                "text" => '<span class="fa fa-download fa-lg icon-unsel" style="color:#137991;"><span class="wb-inv">Export</span></span>',
                "href" => "download_full_discussion/" . $entity->getGUID(),
                "title" => elgg_echo("decommission:discussion:export"),
                "priority" => 10
            ));
        }
    }

    return $result;
}