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
 *****************************************************************************/
?>
<?php

$text   = elgg_extract('text',   $vars, '');
$href   = elgg_extract('href',   $vars, '#');
$target = elgg_extract('target', $vars, '');
$title  = elgg_extract('title',  $vars, '');
$class  = elgg_extract('class',  $vars, '');
$rel    = elgg_extract('rel',    $vars, '');
$id     = elgg_extract('id',     $vars, '');

unset($vars['text']);
unset($vars['href']);
unset($vars['target']);
unset($vars['class']);
unset($vars['rel']);
unset($vars['title']);
unset($vars['id']);

$targets = array('_self', '_blank', /*'_parent', '_top',*/);
if(!in_array($target, $targets)) {
    $target = '_self';
}

$options = array(
    'text'   => $text,
    'target' => $target,
    'title'  => $title,
    'class'  => $class,
    'rel'    => $rel,
    'id'     => $id,
);

if($href) {
    $options['href'] = elgg_format_url($href);
}

$params = $options + $vars;
$content = elgg_view('output/url', $params);

echo $content;

