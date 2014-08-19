<?php

function phloor_elgg_thumbnails_instanceof($entity) {
    return ($entity instanceof AbstractPhloorElggThumbnails);
}

function phloor_thumbnails_create_thumbnails(&$thumbnailObject) {
    if(!phloor_elgg_thumbnails_instanceof($thumbnailObject)) {
        return false;
    }
    if(!$thumbnailObject->hasImage()) {
        return false;
    }

    $icon_sizes = elgg_get_config('icon_sizes');

    $guid  = $thumbnailObject->guid;
    $image = $thumbnailObject->image;
    $mime  = $thumbnailObject->getMime();

    $file = new ElggFile();
    $file->owner_guid = elgg_get_logged_in_user_guid();
    $file->setMimeType($mime);

    $prefix = "phloor_elgg_image/phloor_elgg_thumbnails/";

    $files = array();
    foreach ($icon_sizes as $name => $size_info) {
        $resized = get_resized_image_from_existing_file($image, $size_info['w'], $size_info['h'], $size_info['square']);

        if ($resized) {
            //$clean_title = ereg_replace("[^A-Za-z0-9]", "", $title);

            $file->setFilename("$prefix$guid.$name.jpeg");
            $file->open('write');
            $file->write($resized);
            $file->close();

            $thumbnailObject->set("thumb$name", $file->getFilenameOnFilestore());

            $files[] = $file;
        } else {
            // cleanup on fail
            foreach ($files as $file) {
                $file->delete();
            }

            register_error(elgg_echo('phloor:resize:fail'));
            return false;
        }
    }

    return $thumbnailObject->save();
}
