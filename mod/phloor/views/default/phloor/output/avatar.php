<?php
/*****************************************************************************
 * Phloor                                                                    *
 *                                                                           *
 * Copyright (C) 2011, 2012 Alois Leitner                                    *
 *                                                                           *
 * This program is free software: you can redistribute it and/or modify      *
 * it under the terms of the GNU General Public License as published by      *
 * the Free Software Foundation, either version 2 of the License, or         *
 * (at your option) any later version.                                       *
 *                                                                           *
 * This program is distributed in the hope that it will be useful,           *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 * GNU General Public License for more details.                              *
 *                                                                           *
 * You should have received a copy of the GNU General Public License         *
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.     *
 *                                                                           *
 * "When code and comments disagree both are probably wrong." (Norm Schryer) *
 ****************************************************************************/
?>
<?php
/**
 * phloor Avatar
 *
 */

$entity   = elgg_extract('entity',   $vars, null);
$size     = elgg_extract('size',     $vars, 'small');
$use_link = elgg_extract('use_link', $vars, true);
$link_url = elgg_extract('link_url', $vars, '');
$src      = elgg_extract('src',      $vars, false);
$alt      = elgg_extract('alt',      $vars, '');
$title    = elgg_extract('title',    $vars, false);


if (!in_array($size, array('topbar', 'thumb', 'tiny', 'small', 'medium', 'large'))) {
	$size = 'small';
}

if (elgg_instanceof($entity)) {
	if($use_link && empty($link_url)) {
	    $link_url = $entity->getURL();
	}
	if($title !== false && empty($title)) {
	    $title = $entity->title;
	}
	// replace $src with entity icon
    if($src === false) {
        $src = elgg_format_url($entity->getIconURL($size));
    }
}

// if src is now false.. break up.
if($src === false) {
    return false;
}

$class = "elgg-avatar elgg-avatar-$size phloor-avatar-$size";
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

$img_class = '';
if (isset($vars['img_class'])) {
	$img_class = $vars['img_class'];
}

$name = '';
if($title !== false) {
    $name = htmlspecialchars($title, ENT_QUOTES, 'UTF-8', false);
}

$icontime = "default";

$spacer_url = elgg_get_site_url() . '_graphics/spacer.gif';

$icon = elgg_view('output/img', array(
	'src' => $spacer_url,
	'alt'   => $alt,
	'title' => $name,
	'class' => $img_class,
	'style' => "background: url($src) no-repeat;",
));


?>
<div class="<?php echo $class; ?>">
<?php
if ($use_link) {
	$class = elgg_extract('link_class', $vars, '');
	$url = elgg_extract('href', $vars, $link_url);
	echo elgg_view('output/url', array(
		'href' => $url,
		'text' => $icon,
		'is_trusted' => true,
		'class' => $class,
	));
} else {
	echo "<a>$icon</a>";
}
?>
</div>
