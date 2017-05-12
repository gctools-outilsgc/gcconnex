<?php
/**
 * Elgg API Admin
 * Implementation of the Revoke Keys option on an API Key object
 * 
 * @package ElggAPIAdmin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * 
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2011
 * @link http://www.elgg.org
*/

admin_gatekeeper();

$key = (int)get_input('keyid');

$obj = get_entity($key);

if ( $obj && ($obj instanceof ElggObject) && ($obj->subtype == get_subtype_id('object', 'api_key')) ) {
	if ( $obj->delete() ) {
		system_message(elgg_echo('apiadmin:keyrevoked'));
	} else {
		register_error(elgg_echo('apiadmin:keynotrevoked'));
	}
} else {
	register_error(elgg_echo('apiadmin:keynotrevoked'));
}

forward(REFERER);
