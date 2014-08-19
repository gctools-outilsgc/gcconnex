<?php

function phloor_elgg_image_instanceof($entity) {
    return ($entity instanceof AbstractPhloorElggImage);
}

/**
 * Checks if an PhloorElggImages attributes
 * can be applied with certain parameters
 *
 * @param $object the image entity
 * @param $params the attributes to check
 */
function phloor_elgg_image_check_vars($object, &$params) {
    // @todo:
    if(!phloor_elgg_image_instanceof($object)) {
    //if(!elgg_instanceof($object)) {
        return false;
    }

    // delete image if checkbox was set
    if(strcmp('true', $params['delete_image']) == 0 &&
        $object->hasImage() &&
        $object->canEdit()) {
        $object->deleteImage();
        // reset the delete_image var
        unset($params['delete_image']);
    }

    // see if an image has been set.. if not.. explicitly reassign the current one!
    if (!isset($params['image']) || empty($params['image']) || $params['image']['error'] == 4) {
        $params['image'] = $object->hasImage() ? $object->image : '';
    } else {
        $mime = array(
			'image/gif' => 'gif',
			'image/jpg' => 'jpeg',
			'image/jpeg' => 'jpeg',
			'image/pjpeg' => 'jpeg',
			'image/png' => 'png',
        );

        if (!array_key_exists($params['image']['type'], $mime)) {
            register_error(elgg_echo('phloor:image_mime_type_not_supported', array(
                $params['image']['type'],
            )));
            return false;
        }
        if ($params['image']['error'] != 0) {
            register_error(elgg_echo('phloor:upload_error', array(
                $params['image']['error'],
            )));
            return false;
        }

        $tmp_filename = $params['image']['tmp_name'];
        $params['mime'] = $params['image']['type'];

        // determine filename (clean title)
        $clean_title = ereg_replace("[^A-Za-z0-9]", "", $params['title']); // just numbers and letters
        $filename = $clean_title . '.' . time() . '.' . $mime[$params['mime']];
        $prefix = "{$object->getSubtype()}/images/";

        $image = new ElggFile();
        $image->setMimeType($params['mime']);
        $image->setFilename($prefix . $filename);
        $image->open("write");
        $image->close();

        // move the file to the data directory
        $move = move_uploaded_file($_FILES['image']['tmp_name'], $image->getFilenameOnFilestore());
        // report errors if that did not succeed
        if(!$move) {
            register_error(elgg_echo('phloor:couldnotmoveuploadedfile'));
            return false;
        }

        $params['image'] = $image->getFilenameOnFilestore();
    }

    return true;
}