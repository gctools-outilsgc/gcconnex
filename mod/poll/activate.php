<?php
/**
 * Register the Poll class for the object/poll subtype
 */

if (get_subtype_id('object', 'poll')) {
	update_subtype('object', 'poll', 'Poll');
} else {
	add_subtype('object', 'poll', 'Poll');
}
