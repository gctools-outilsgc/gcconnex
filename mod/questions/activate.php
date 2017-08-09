<?php
/**
 * This file is executed when the plugin is enabled
 */

// register our own classes
if (get_subtype_id('object', 'question')) {
	update_subtype('object', 'question', 'ElggQuestion');
} else {
	add_subtype('object', 'question', 'ElggQuestion');
}

if (get_subtype_id('object', 'answer')) {
	update_subtype('object', 'answer', 'ElggAnswer');
} else {
	add_subtype('object', 'answer', 'ElggAnswer');
}
