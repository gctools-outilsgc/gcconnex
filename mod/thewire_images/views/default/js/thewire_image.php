<?php
/**
 * JS to alter the encoding type for the wire post forms.
 */
?>

//<script>
elgg.provide('elgg.thewire_image');

/**
 * Finds the wire post forms and changes the enc type
 */
elgg.thewire_image.init = function() {
	$('input.thewire-image').parents('form').attr('enctype', 'multipart/form-data');
}

elgg.register_hook_handler('init', 'system', elgg.thewire_image.init);