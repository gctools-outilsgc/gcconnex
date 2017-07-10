<?php
/**
 * Create new album page
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$owner = elgg_get_page_owner_entity();
$lang = get_current_language();

elgg_gatekeeper();
elgg_group_gatekeeper();

$title = elgg_echo('photos:add');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
if (elgg_instanceof($owner, 'user')) {
	elgg_push_breadcrumb(gc_explode_translation($owner->name,$lang), "photos/owner/$owner->username");
} else {
	elgg_push_breadcrumb(gc_explode_translation($owner->name,$lang), "photos/group/$owner->guid/all");
}
elgg_push_breadcrumb($title);

$vars = tidypics_prepare_form_vars();
$content = elgg_view_form('photos/album/save', array('method' => 'post'), $vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar' => elgg_view('photos/sidebar_al', array('page' => 'upload')),
));

echo elgg_view_page($title, $body);
