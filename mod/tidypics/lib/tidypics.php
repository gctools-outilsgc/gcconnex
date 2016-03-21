<?php
/**
 * Elgg tidypics library of common functions
 *
 * @package TidypicsCommon
 */

/**
 * Get images for display on front page
 *
 * @param int number of images
 * @param array (optional) array of owner guids
 * @param string (optional) context of view to display
 * @return string of html for display
 */
function tp_get_latest_photos($num_images, array $owner_guids = NULL, $context = 'front') {
        $prev_context = elgg_get_context();
        elgg_set_context($context);
        $image_html = elgg_list_entities(array(
        'type' => 'object',
        'subtype' => 'image',
        'owner_guids' => $owner_guids,
        'limit' => $num_images,
        'full_view' => false,
        'list_type_toggle' => false,
        'list_type' => 'gallery',
        'pagination' => false,
        'gallery_class' => 'tidypics-gallery-widget',
        ));
        elgg_set_context($prev_context);
        return $image_html;
}

/**
 * Get albums for display on front page
 *
 * @param int number of albums
 * @param array (optional) array of container_guids
 * @param string (optional) context of view to display
 * @return string of html for display
 */
function tp_get_latest_albums($num_albums, array $container_guids = NULL, $context = 'front') {
        $prev_context = elgg_get_context();
        elgg_set_context($context);
        $image_html = elgg_list_entities(array(
        'type' => 'object',
        'subtype' => 'album',
        'container_guids' => $container_guids,
        'limit' => $num_albums,
        'full_view' => false,
        'pagination' => false,
        ));
        elgg_set_context($prev_context);
        return $image_html;
}


/**
 * Get image directory path
 *
 * Each album gets a subdirectory based on its container id
 *
 * @return string	path to image directory
 */
function tp_get_img_dir($album_guid) {
	$file = new ElggFile();
	$file->setFilename("image/$album_guid");
	return $file->getFilenameOnFilestore($file);
}

/**
 * Prepare vars for a form, pulling from an entity or sticky forms.
 *
 * @param type $entity
 * @return type
 */
function tidypics_prepare_form_vars($entity = null) {
	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $entity,
	);

	if ($entity) {
		foreach (array_keys($values) as $field) {
			if (isset($entity->$field)) {
				$values[$field] = $entity->$field;
			}
		}
	}

	if (elgg_is_sticky_form('tidypics')) {
		$sticky_values = elgg_get_sticky_values('tidypics');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('tidypics');

	return $values;
}

/**
 * Returns available image libraries.
 *
 * @return string
 */
function tidypics_get_image_libraries() {
	$options = array();
	if (extension_loaded('gd')) {
		$options['GD'] = 'GD';
	}

	if (extension_loaded('imagick')) {
		$options['ImageMagickPHP'] = 'imagick PHP extension';
	}

	$disablefunc = explode(',', ini_get('disable_functions'));
	if (is_callable('exec') && !in_array('exec', $disablefunc)) {
		$options['ImageMagick'] = 'ImageMagick executable';
	}

	return $options;
}

/**
 * Are there upgrade scripts to be run?
 *
 * @return bool
 */
function tidypics_is_upgrade_available() {
	// sets $version based on code
	require_once elgg_get_plugins_path() . "tidypics/version.php";

	$local_version = elgg_get_plugin_setting('version', 'tidypics');
	if ($local_version === null) {
		// no version set so either new install or really old one
		if (!get_subtype_class('object', 'image') || !get_subtype_class('object', 'album')) {
			$local_version = 0;
		} else {
			// set initial version for new install
			elgg_set_plugin_setting('version', $version, 'tidypics');
			$local_version = $version;
		}
	} elseif ($local_version === '1.62') {
		// special work around to handle old upgrade system
		$local_version = 2010010101;
		elgg_set_plugin_setting('version', $local_version, 'tidypics');
	}

	if ($local_version == $version) {
		return false;
	} else {
		return true;
	}
}

/**
 * This lists the photos in an album as sorted by metadata
 *
 * @todo this only supports a single album. The only case for use a
 * procedural function like this instead of TidypicsAlbum::viewImgaes() is to
 * fetch images across albums as a helper to elgg_get_entities().
 * This should function be deprecated or fixed to work across albums.
 *
 * @param array $options
 * @return string
 */
function tidypics_list_photos(array $options = array()) {
	global $autofeed;
	$autofeed = true;

	$defaults = array(
		'offset' => (int) max(get_input('offset', 0), 0),
		'limit' => (int) max(get_input('limit', 10), 0),
		'full_view' => true,
		'list_type_toggle' => false,
		'pagination' => true,
	);

	$options = array_merge($defaults, $options);

	$options['count'] = true;
	$count = elgg_get_entities($options);

	$album = get_entity($options['container_guid']);
	if ($album) {
		$guids = $album->getImageList();
		// need to pass all the guids and handle the limit / offset in sql
		// to avoid problems with the navigation
		//$guids = array_slice($guids, $options['offset'], $options['limit']);
		$options['guids'] = $guids;
		unset($options['container_guid']);
	}
	$options['count'] = false;
	$entities = elgg_get_entities($options);

	$keys = array();
	foreach ($entities as $entity) {
		$keys[] = $entity->guid;
	}

	$entities = array_combine($keys, $entities);

	$sorted_entities = array();
	foreach ($guids as $guid) {
		if (isset($entities[$guid])) {
			$sorted_entities[] = $entities[$guid];
		}
	}

	// for this function count means the total number of entities
	// and is required for pagination
	$options['count'] = $count;

	return elgg_view_entity_list($sorted_entities, $options);
}

/**
 * Returns just a guid from a database $row. Used in elgg_get_entities()'s callback.
 *
 * @param stdClass $row
 * @return type
 */
function tp_guid_callback($row) {
	return ($row->guid) ? $row->guid : false;
}


/**
 * the functions below replace broken core functions or add functions
 * that could/should exist in the core
 */

/**
 * Is the request from a known browser
 *
 * @return true/false
 */
function tp_is_person() {
	$known = array('msie', 'mozilla', 'firefox', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko');

	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);

	foreach ($known as $browser) {
		if (strpos($agent, $browser) !== false) {
			return true;
		}
	}

	return false;
}
