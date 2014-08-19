<?php

/**
 * view a phloor sprite icon
 *
 * shorthand for <span class="phloor-icon phloor-icon-$name"></span>
 *
 * @param string $name  icon name
 * @param string $class additional class
 *
 * @return string html string for displaying the icon
 */
function phloor_view_icon($name, $class = '') {
	return "<span class=\"phloor-icon phloor-icon-$name $class\"></span>";
}