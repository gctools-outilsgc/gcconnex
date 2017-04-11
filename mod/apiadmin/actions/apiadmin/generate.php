<?php
/**
 * Elgg API Admin
 * Implementation of the Generate Keys form action
 * 
 * @package ElggAPIAdmin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * 
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2011
 * @link http://www.elgg.org
*/

global $CONFIG;

admin_gatekeeper();

$ref = get_input('ref');

if ( $ref ) {
	$keypair = create_api_user($CONFIG->site_id);

	if ( $keypair ) {

		$newkey = new ElggObject();
		$newkey->subtype = 'api_key';
		$newkey->access_id = ACCESS_PUBLIC;
		$newkey->title = $ref;
		$newkey->public = $keypair->api_key;

		if ( !$newkey->save() ) {
			register_error(elgg_echo('apiadmin:generationfail'));
		} else {
			system_message(elgg_echo('apiadmin:generated'));
		}
	} else {
		register_error(elgg_echo('apiadmin:generationfail'));
	}
} else {
	register_error(elgg_echo('apiadmin:noreference'));
}

forward(REFERER);
