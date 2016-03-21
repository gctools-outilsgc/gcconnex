<?php
/**
 * Photo Gallery plugin
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

elgg_register_event_handler('init', 'system', 'tidypics_init');

/**
 * Tidypics plugin initialization
 */
function tidypics_init() {
	// Register libraries
	$base_dir = elgg_get_plugins_path() . 'tidypics/lib';
	elgg_register_library('tidypics:core', "$base_dir/tidypics.php");
	elgg_register_library('tidypics:upload', "$base_dir/upload.php");
	elgg_register_library('tidypics:resize', "$base_dir/resize.php");
	elgg_register_library('tidypics:exif', "$base_dir/exif.php");
	elgg_load_library('tidypics:core');
	
	// Register an ajax view that allows selection of album to upload images to
	elgg_register_ajax_view('photos/selectalbum');

	// Register an ajax view for the broken images cleanup routine
	elgg_register_ajax_view('photos/broken_images_delete_log');

	// Set up site menu
	$site_menu_links_to = elgg_get_plugin_setting('site_menu_link', 'tidypics');
	if ($site_menu_links_to == 'albums') {
		elgg_register_menu_item('site', array(
			'name' => 'photos',
			'href' => 'photos/all',
			'text' => elgg_echo('photos'),
		));
	} else {
		elgg_register_menu_item('site', array(
			'name' => 'photos',
			'href' => 'photos/siteimagesall',
			'text' => elgg_echo('photos'),
		));
	}

	// Register a page handler so we can have nice URLs
	elgg_register_page_handler('photos', 'tidypics_page_handler');

	// Extend CSS
	elgg_extend_view('css/elgg', 'photos/css');
	elgg_extend_view('css/admin', 'photos/css');

	// Register the JavaScript libs
	elgg_register_js('tidypics:slideshow', 'mod/tidypics/vendors/PicLensLite/piclens.js');
	elgg_register_js('jquery.plupload-tp', 'mod/tidypics/vendors/plupload/js/plupload.full.min.js', 'footer');
	elgg_register_js('jquery.plupload.ui-tp', 'mod/tidypics/vendors/plupload/js/jquery.ui.plupload/jquery.ui.plupload.min.js', 'footer');
	$plupload_language = get_plugload_language();
	elgg_register_js('jquery.plupload.ui.lang-tp', 'mod/tidypics/vendors/plupload/js/i18n/' . $plupload_language . '.js', 'footer');
	elgg_register_css('jquery.plupload.jqueryui-theme', 'mod/tidypics/vendors/jqueryui/css/smoothness/jquery-ui.min.css');
	elgg_register_css('jquery.plupload.ui', 'mod/tidypics/vendors/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css');

	// Add photos link to owner block/hover menus
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'tidypics_owner_block_menu');

	// Add admin menu item
	elgg_register_admin_menu_item('configure', 'photos', 'settings');

	// Register for search
	elgg_register_entity_type('object', 'image');
	elgg_register_entity_type('object', 'album');

	// Register for the entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'tidypics_entity_menu_setup');

	// Register group options
	add_group_tool_option('photos', elgg_echo('tidypics:enablephotos'), true);
	elgg_extend_view('groups/tool_latest', 'photos/group_module');
	add_group_tool_option('tp_images', elgg_echo('tidypics:enable_group_images'), true);
	elgg_extend_view('groups/tool_latest', 'photos/group_tp_images_module');

	// Register widgets
	elgg_register_widget_type('album_view', elgg_echo("tidypics:widget:albums"), elgg_echo("tidypics:widget:album_descr"), array('profile'));
	elgg_register_widget_type('latest_photos', elgg_echo("tidypics:widget:latest"), elgg_echo("tidypics:widget:latest_descr"), array('profile'));
	
	if (elgg_is_active_plugin('widget_manager')) {
		//add index widgets for Widget Manager plugin
		elgg_register_widget_type('index_latest_photos', elgg_echo("tidypics:mostrecent"), elgg_echo('tidypics:mostrecent:description'), array('index'));
		elgg_register_widget_type('index_latest_albums', elgg_echo("tidypics:albums_mostrecent"), elgg_echo('tidypics:albums_mostrecent:description'), array('index'));

		//add groups widgets for Widget Manager plugin
		elgg_register_widget_type('groups_latest_photos', elgg_echo("tidypics:mostrecent"), elgg_echo('tidypics:mostrecent:description'), array('groups'));
		elgg_register_widget_type('groups_latest_albums', elgg_echo("tidypics:albums_mostrecent"), elgg_echo('tidypics:albums_mostrecent:description'), array('groups'));

		//register title urls for widgets
		elgg_register_plugin_hook_handler("entity:url", "object", "tidypics_widget_urls");
	}

	// RSS extensions for embedded media
	elgg_extend_view('extensions/xmlns', 'extensions/photos/xmlns');

	// allow group members add photos to group albums
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'tidypics_group_permission_override');
	elgg_register_plugin_hook_handler('permissions_check:metadata', 'object', 'tidypics_group_permission_override');

	// notifications
	elgg_register_notification_event('object', 'album', array('album_first', 'album_more'));
	elgg_register_plugin_hook_handler('prepare', 'notification:album_first:object:album', 'tidypics_notify_message');
	elgg_register_plugin_hook_handler('prepare', 'notification:album_more:object:album', 'tidypics_notify_message');

	// allow people in a walled garden to use flash uploader
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'tidypics_walled_garden_override');

	// override the default url to view a tidypics_batch object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'tidypics_batch_url_handler');

	// custom layout for comments on tidypics river entries
	elgg_register_plugin_hook_handler('creating', 'river', 'tidypics_comments_handler');

	// Register actions
	$base_dir = elgg_get_plugins_path() . 'tidypics/actions/photos';
	elgg_register_action("photos/delete", "$base_dir/delete.php");

	elgg_register_action("photos/album/save", "$base_dir/album/save.php");
	elgg_register_action("photos/album/sort", "$base_dir/album/sort.php");
	elgg_register_action("photos/album/set_cover", "$base_dir/album/set_cover.php");

	elgg_register_action("photos/image/upload", "$base_dir/image/upload.php");
	elgg_register_action("photos/image/save", "$base_dir/image/save.php");
	elgg_register_action("photos/image/ajax_upload", "$base_dir/image/ajax_upload.php", 'logged_in');
	elgg_register_action("photos/image/ajax_upload_complete", "$base_dir/image/ajax_upload_complete.php", 'logged_in');
	elgg_register_action("photos/image/tag", "$base_dir/image/tag.php");
	elgg_register_action("photos/image/untag", "$base_dir/image/untag.php");

	elgg_register_action("photos/batch/edit", "$base_dir/batch/edit.php");

	elgg_register_action("photos/admin/settings", "$base_dir/admin/settings.php", 'admin');
	elgg_register_action("photos/admin/create_thumbnails", "$base_dir/admin/create_thumbnails.php", 'admin');
	elgg_register_action("photos/admin/resize_thumbnails", "$base_dir/admin/resize_thumbnails.php", 'admin');
	elgg_register_action("photos/admin/delete_image", "$base_dir/admin/delete_image.php", 'admin');
	elgg_register_action("photos/admin/upgrade", "$base_dir/admin/upgrade.php", 'admin');
	elgg_register_action("photos/admin/broken_images", "$base_dir/admin/broken_images.php", 'admin');

	elgg_register_action('photos/image/selectalbum', "$base_dir/image/selectalbum.php");
}

/**
 * Tidypics page handler
 *
 * @param array $page Array of url segments
 * @return bool
 */
function tidypics_page_handler($page) {

	if (!isset($page[0])) {
		return false;
	}

	elgg_require_js('tidypics/tidypics');
	elgg_load_js('lightbox');
	elgg_load_css('lightbox');
	if (elgg_get_plugin_setting('slideshow', 'tidypics')) {
		elgg_load_js('tidypics:slideshow');
	}

	$base = elgg_get_plugins_path() . 'tidypics/pages/photos';
	$base_lists = elgg_get_plugins_path() . 'tidypics/pages/lists';
	switch ($page[0]) {
		case "siteimagesall":
			require "$base_lists/siteimagesall.php";
			break;

		case "siteimagesowner":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			require "$base_lists/siteimagesowner.php";
			break;

		case "siteimagesfriends":
			require "$base_lists/siteimagesfriends.php";
			break;

		case "siteimagesgroup":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			require "$base_lists/siteimagesgroup.php";
			break;

		case "all": // all site albums
		case "world":
			require "$base/all.php";
			break;

		case "owned":  // albums owned by container entity
		case "owner":
			require "$base/owner.php";
			break;

		case "friends": // albums of friends
			require "$base/friends.php";
			break;

		case "group": // albums of a group
			require "$base/owner.php";
			break;

		case "album": // view an album individually
			set_input('guid', $page[1]);
			require "$base/album/view.php";
			break;

		case "new":  // create new album
		case "add":
			set_input('guid', $page[1]);
			require "$base/album/add.php";
			break;
			
		case "edit": //edit image or album
			set_input('guid', $page[1]);
			$entity = get_entity($page[1]);
			switch ($entity->getSubtype()) {
				case 'album':
					require "$base/album/edit.php";
					break;
				case 'image':
					require "$base/image/edit.php";
					break;
				case 'tidypics_batch':
					require "$base/batch/edit.php";
					break;
				default:
					return false;
			}
			break;

		case "sort": // sort a photo album
			set_input('guid', $page[1]);
			require "$base/album/sort.php";
			break;

		case "image": //view an image
		case "view":
			set_input('guid', $page[1]);
			require "$base/image/view.php";
			break;

		case "thumbnail": // tidypics thumbnail
			set_input('guid', $page[1]);
			set_input('size', elgg_extract(2, $page, 'small'));
			require "$base/image/thumbnail.php";
			break;

		case "upload": // upload images to album
			set_input('guid', $page[1]);

			if (elgg_get_plugin_setting('uploader', 'tidypics')) {
				$default_uploader = 'ajax';
			} else {
				$default_uploader = 'basic';
			}

			set_input('uploader', elgg_extract(2, $page, $default_uploader));
			require "$base/image/upload.php";
			break;

		case "download": // download an image
			set_input('guid', $page[1]);
			set_input('disposition', elgg_extract(2, $page, 'attachment'));
			include "$base/image/download.php";
			break;

		case "tagged": // all photos tagged with user
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			require "$base/tagged.php";
			break;

		case "mostviewed": // images with the most views
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostviewedimages.php";
			break;

		case "mostviewedtoday":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostviewedimagestoday.php";
			break;

		case "mostviewedthismonth":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostviewedimagesthismonth.php";
			break;

		case "mostviewedlastmonth":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostviewedimageslastmonth.php";
			break;

		case "mostviewedthisyear":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostviewedimagesthisyear.php";
			break;

		case "mostcommented":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostcommentedimages.php";
			break;

		case "mostcommentedtoday":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostcommentedimagestoday.php";
			break;

		case "mostcommentedthismonth":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostcommentedimagesthismonth.php";
			break;

		case "mostcommentedlastmonth":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostcommentedimageslastmonth.php";
			break;

		case "mostcommentedthisyear":
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			require "$base_lists/mostcommentedimagesthisyear.php";
			break;

		case "recentlyviewed":
			require "$base_lists/recentlyviewed.php";
			break;

		case "recentlycommented":
			require "$base_lists/recentlycommented.php";
			break;

		case "recentvotes":
			if(elgg_is_active_plugin('elggx_fivestar')) {
				require "$base_lists/recentvotes.php";
				break;
			} else {
				return false;
			}

		case "highestrated":
			if(elgg_is_active_plugin('elggx_fivestar')) {
				require "$base_lists/highestrated.php";
				break;
			} else {
				return false;
			}

		case "highestvotecount":
			if(elgg_is_active_plugin('elggx_fivestar')) {
				require "$base_lists/highestvotecount.php";
				break;
			} else {
				return false;
			}

		default:
			return false;
	}

	return true;
}

/**
 * Add a menu item to an ownerblock
 */
function tidypics_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "photos/siteimagesowner/{$params['entity']->guid}";
		$item = new ElggMenuItem('photos', elgg_echo('photos'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->tp_images_enable != "no") {
			$url = "photos/siteimagesgroup/{$params['entity']->guid}";
			$item = new ElggMenuItem('photos', elgg_echo('photos:group'), $url);
			$return[] = $item;
		}
	}

	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "photos/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('photo_albums', elgg_echo('albums'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->photos_enable != "no") {
			$url = "photos/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('photo_albums', elgg_echo('photos:group_albums'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add Tidypics links/info to entity menu
 */
function tidypics_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'photos') {
		return $return;
	}

	if (elgg_instanceof($entity, 'object', 'image')) {
		$album = $entity->getContainerEntity();
		$cover_guid = $album->getCoverImageGuid();
		if ($cover_guid != $entity->getGUID() && $album->canEdit()) {
			$url = 'action/photos/album/set_cover'
				. '?image_guid=' . $entity->getGUID()
				. '&album_guid=' . $album->getGUID();

			$params = array(
				'href' => $url,
				'text' => elgg_echo('album:cover_link'),
				'is_action' => true,
				'is_trusted' => true,
				'confirm' => elgg_echo('album:cover')
			);
			$text = elgg_view('output/url', $params);

			$options = array(
				'name' => 'set_cover',
				'text' => $text,
				'priority' => 80,
			);
			$return[] = ElggMenuItem::factory($options);
		}

		if (elgg_get_plugin_setting('view_count', 'tidypics')) {
			$view_info = $entity->getViewInfo();
			$text = elgg_echo('tidypics:views', array((int)$view_info['total']));
			$options = array(
				'name' => 'views',
				'text' => "<span>$text</span>",
				'href' => false,
				'priority' => 90,
			);
			$return[] = ElggMenuItem::factory($options);
		}

		$restrict_tagging = elgg_get_plugin_setting('restrict_tagging', 'tidypics');
		if (elgg_get_plugin_setting('tagging', 'tidypics') && elgg_is_logged_in() && (!$restrict_tagging || ($restrict_tagging && $entity->canEdit()))) {
			$options = array(
				'name' => 'tagging',
				'text' => elgg_echo('tidypics:actiontag'),
				'href' => '#',
				'title' => elgg_echo('tidypics:tagthisphoto'),
				'rel' => 'photo-tagging',
				'priority' => 80,
			);
			$return[] = ElggMenuItem::factory($options);
		}
	}

	return $return;
}


function tidypics_widget_urls($hook_name, $entity_type, $return_value, $params){
	$result = $return_value;
	$widget = $params["entity"];

	if(empty($result) && ($widget instanceof ElggWidget)) {
		$owner = $widget->getOwnerEntity();
		switch($widget->handler) {
			case "latest_photos":
				$result = "/photos/siteimagesowner/" . $owner->guid;
				break;
			case "album_view":
				$result = "/photos/owner/" . $owner->username;
				break;
			case "index_latest_photos":
				$result = "/photos/siteimagesall";
				break;
			case "index_latest_albums":
				$result = "/photos/all";
				break;
			case "groups_latest_photos":
				if($owner instanceof ElggGroup){
					$result = "photos/siteimagesgroup/{$owner->guid}";
				} else {
					$result = "/photos/siteimagesowner/" . $owner->guid;
				}
				break;
			case "groups_latest_albums":
				if($owner instanceof ElggGroup){
					$result = "photos/group/{$owner->guid}/all";
				} else {
					$result = "/photos/owner/" . $owner->username;
				}
				break;
		}
	}
	return $result;
}

/**
 * Override permissions for group albums
 *
 * 1. To write to a container (album) you must be able to write to the owner of the container (odd)
 * 2. We also need to change metadata on the album
 *
 * @param string $hook
 * @param string $type
 * @param bool   $result
 * @param array  $params
 * @return mixed
 */
function tidypics_group_permission_override($hook, $type, $result, $params) {
	$action_name_input = get_input('tidypics_action_name');
	if ($action_name_input == 'tidypics_photo_upload') {
		if (isset($params['container'])) {
			$album = $params['container'];
		} else {
			$album = $params['entity'];
		}

		if (elgg_instanceof($album, 'object', 'album')) {
			return $album->getContainerEntity()->canWriteToContainer();
		}
	}
}


/**
 *
 * Prepare a notification message about a new images added to an album
 *
 * Does not run if a new album without photos
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg_Notifications_Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg_Notifications_Notification (on Elgg 1.9); mixed (on Elgg 1.8)
 */
function tidypics_notify_message($hook, $type, $notification, $params) {

	$entity = $params['event']->getObject();

	if (elgg_instanceof($entity, 'object', 'album')) {

		$owner = $params['event']->getActor();
		$recipient = $params['recipient'];
		$language = $params['language'];
		$method = $params['method'];

		$descr = $entity->description;
		$title = $entity->getTitle();

		if ($type == 'notification:album_first:object:album') {
			$notification->subject = elgg_echo('tidypics:notify:subject_newalbum', array($entity->title), $language);
			$notification->body = elgg_echo('tidypics:notify:body_newalbum', array($owner->name, $title, $entity->getURL()), $language);
			$notification->summary = elgg_echo('tidypics:notify:summary_newalbum', array($entity->title), $language);

			return $notification;
		} else {
			$notification->subject = elgg_echo('tidypics:notify:subject_updatealbum', array($entity->title), $language);
			$notification->body = elgg_echo('tidypics:notify:body_updatealbum', array($owner->name, $title, $entity->getURL()), $language);
			$notification->summary = elgg_echo('tidypics:notify:summary_updatealbum', array($entity->title), $language);

			return $notification;
		}
	}
}

/**
 * Allows the flash uploader actions through walled garden since
 * they come without the session cookie
 */
function tidypics_walled_garden_override($hook, $type, $pages) {
	$pages[] = 'action/photos/image/ajax_upload';
	$pages[] = 'action/photos/image/ajax_upload_complete';
	return $pages;
}

/**
 * return the album url of the album the tidypics_batch entitities belongs to
 */
function tidypics_batch_url_handler($hook, $type, $url, $params) {
	$batch = $params['entity'];
	if (elgg_instanceof($batch, 'object', 'tidypics_batch')) {
		if (!$batch->getOwnerEntity()) {
			// default to a standard view if no owner.
			return false;
		}

		$album = get_entity($batch->container_guid);

		return $album->getURL();
	}
}

/**
 * custom layout for comments on tidypics river entries
 *
 * Overriding generic_comment view
 */
function tidypics_comments_handler($hook, $type, $value, $params) {

	$result = $value;

	$action_type = $value['action_type'];
	if ($action_type != 'comment') {
		return;
	}

	$target_guid =  $value['target_guid'];
	if (!$target_guid) {
		return;
	}
	$target_entity = get_entity($target_guid);
	$subtype = $target_entity->getSubtype();

	if ($subtype == 'image') {
		// update river entry attributes
		$result['view'] = 'river/object/comment/image';
	} else if ($subtype == 'album') {
		// update river entry attributes
		$result['view'] = 'river/object/comment/album';
	} else {
		return;
	}

	return $result;
}

function get_plugload_language() {

	if ($current_language = get_current_language()) {
		$path = elgg_get_plugins_path() . "tidypics/vendors/plupload/js/i18n";
		if (file_exists("$path/$current_language.js")) {
			return $current_language;
		}
	}

	return 'en';
}

function tidypics_get_last_log_line($filename) {
	$line = false;
	$f = false;
	if (file_exists($filename)) {
		$f = @fopen($filename, 'r');
	}

	if ($f === false) {
		return false;
	} else {
		$cursor = -1;

		fseek($f, $cursor, SEEK_END);
		$char = fgetc($f);

		/**
		 * Trim trailing newline chars of the file
		 */
		while ($char === "\n" || $char === "\r") {
			fseek($f, $cursor--, SEEK_END);
			$char = fgetc($f);
		}

		/**
		 * Read until the start of file or first newline char
		 */
		while ($char !== false && $char !== "\n" && $char !== "\r") {
			/**
			 * Prepend the new char
			 */
			$line = $char . $line;
			fseek($f, $cursor--, SEEK_END);
			$char = fgetc($f);
		}
	}

	return $line;
}

function tidypics_get_log_location($time) {
	return elgg_get_config('dataroot') . 'tidypics_log' . '/' . $time . '.txt';
}
