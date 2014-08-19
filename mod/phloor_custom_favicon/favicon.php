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
/**
 * handles instances of AbstractPhloorElggImage and
 * AbstractPhloorElggThumnails
 *
 * tries to load the thumbnails with the given size
 * falls back to image if it exists
 *
 */

$image = elgg_get_root_path() . '_graphics/favicon.ico';
$mime = "image/vnd.microsoft.icon";

if (phloor_custom_favicon_favicon_exists()) {
    $favicon = phloor_custom_favicon_get_favicon();
    if (phloor_elgg_thumbnails_instanceof($favicon)) {
        $image = $favicon->getThumbnail('topbar');
        $mime = "image/jpeg";
    }
}

if (!empty($image) && file_exists($image) && is_file($image)) {
    // get file contents
    $contents = file_get_contents($image);
    // caching images for 10 days
    header("Content-type: $mime"); // jpeg for thumbs
    header('Expires: ' . date('r', time() + 864000));
    header("Pragma: public", true);
    header("Cache-Control: public", true);
    header("Content-Length: " . strlen($contents));
    echo $contents;
}

exit();
