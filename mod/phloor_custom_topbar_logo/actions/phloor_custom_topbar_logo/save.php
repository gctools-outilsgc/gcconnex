<?php
/*****************************************************************************
 * Phloor Topbar Logo                                                        *
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

admin_gatekeeper();

// check if upload failed
if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] != 0) {
	register_error(elgg_echo('phloor_custom_topbar_logo:error:cannotloadimage'));
	forward(REFERER);
}

// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

$delete_files = array();

$new_topbar_logo = false;

$topbar_logo = null;
if(phloor_custom_topbar_logo_topbar_logo_exists()) {
    $topbar_logo = phloor_custom_topbar_logo_get_topbar_logo();

	if (!phloor_custom_topbar_logo_instanceof($topbar_logo) || !$topbar_logo->canEdit()) {
		register_error(elgg_echo('phloor_custom_topbar_logo:error:topbar_logo_not_found'));
		forward(get_input('forward', REFERER));
		exit();
	}

	// determine files to delete (old images and thumbnails)
	if (isset ($_FILES['image']['name']) &&
		!empty($_FILES['image']['name']) &&
		$_FILES['image']['error'] == 0 ) {
		$delete_files = array_merge(array('image' => $topbar_logo->getImage()), $topbar_logo->getThumbnails());
	}

} else {
    $topbar_logo = new PhloorTopbarLogo();
    $topbar_logo->owner_guid = $site->guid;

    $new_topbar_logo = true;
}

$params = phloor_custom_topbar_logo_get_input_vars();

if (phloor_custom_topbar_logo_save_vars($topbar_logo, $params)) {
    // delete former image if new image was uploaded
	if (isset ($_FILES['image']['name']) &&
		!empty($_FILES['image']['name']) &&
		$_FILES['image']['error'] == 0 ) {
		foreach($delete_files as $file) {
			if(!empty($file) && file_exists($file) && is_file($file)) {
				// delete file
				if(@unlink($file)) {
				}
			}
		}

		// recreate thumbnails
		$topbar_logo->recreateThumbnails();
	}

	system_message(elgg_echo('phloor_custom_topbar_logo:save:success'));
}
// ... or display an error message on failure
else {
	register_error(elgg_echo('phloor_custom_topbar_logo:save:failure'));
	forward($error_forward_url);
}

// back o da bus
forward($_SERVER['HTTP_REFERER']);
exit();

