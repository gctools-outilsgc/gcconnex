<?php
/**
 * Deletion of a Tidypics image by GUID provided (if image entry does not get properly displayed on site and delete button can not be reached)
 *
 * iionly@gmx.de
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (!$entity) {
    // unable to get Elgg entity
    register_error(elgg_echo('tidypics:delete_image:no_guid'));
    forward(REFERER);
}

$subtype = $entity->getSubtype();
switch ($subtype) {
    case 'image':
        if ($entity->delete()) {
                system_message(elgg_echo('tidypics:delete_image:success'));
        } else {
                register_error(elgg_echo('tidypics:deletefailed'));
        }
        break;
    default:
        register_error(elgg_echo('tidypics:delete_image:no_image'));
        break;
}

forward(REFERER);
