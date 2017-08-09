<?php
/**
 * This script is run during plugin activation
 */

// set some class handlers
if (get_subtype_id('object', GroupMail::SUBTYPE)) {
	update_subtype('object', GroupMail::SUBTYPE, 'GroupMail');
} else {
	add_subtype('object', GroupMail::SUBTYPE, 'GroupMail');
}
