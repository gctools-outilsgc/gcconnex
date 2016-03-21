<?php
/**
 * Summary of an image for lists/galleries
 *
 * @uses $vars['entity'] TidypicsImage
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$image = elgg_extract('entity', $vars);

$img = elgg_view_entity_icon($image, 'tiny');

echo elgg_view('output/url', array(
               'text' => $img,
               'href' => $image->getURL(),
               'encode_text' => false,
               'is_trusted' => true,
              ));
