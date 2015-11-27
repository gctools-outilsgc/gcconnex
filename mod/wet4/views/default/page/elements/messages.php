<?php
/**
 * Elgg global system message list
 * Lists all system messages
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['object'] The array of message registers
 */

//echo '<ul class="elgg-system-messages custom-message">';

// hidden li so we validate
//echo '<li class="hidden wb-invisible"></li>';

if (isset($vars['object']) && is_array($vars['object']) && sizeof($vars['object']) > 0) {
	foreach ($vars['object'] as $type => $list ) {
        echo '<ul class="alert alert-'.$type.'" style="list-style:disc; padding-left:30px;">';

// hidden li so we validate
echo '<li class="hidden wb-invisible"></li>';
		foreach ($list as $message) {
			echo "<li>";
			echo elgg_autop($message);
			echo '</li>';
		}
	}
}

echo '</ul>';
