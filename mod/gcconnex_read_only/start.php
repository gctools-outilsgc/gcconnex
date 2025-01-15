<?php
/*
* GC-Elgg Read Only Mode 
*
* Read only mode for gcconnex
*
* @author Adi github.com/AdiMakkar
* @version 1.0
*/

elgg_register_event_handler('init', 'system', 'read_only_mode');

function read_only_mode(){
    elgg_register_event_handler('pagesetup', 'system', 'remove_add_buttons');

    elgg_unregister_page_handler('photos');
    elgg_register_page_handler('photos', 'tidypics_read_only');

    elgg_unregister_page_handler('file');
    elgg_register_page_handler('file', 'file_read_only_handler');
}

function remove_add_buttons(){
    $remove_contexts = ['blog', 'discussion', 'bookmarks', 'pages', 'groups'];
    if (in_array(elgg_get_context(), $remove_contexts)) {
        elgg_unregister_menu_item('title', 'add');
    }
}

function init_ajax_block_no_edit($title, $section, $user) {

    switch($section){
        case 'about-me':
            $field = elgg_echo('gcconnex_profile:about_me');
            break;
        case 'education':
            $field = elgg_echo('gcconnex_profile:education');
            break;
        case 'work-experience':
            $field = elgg_echo('gcconnex_profile:experience');
            break;
        case 'skills':
            $field = elgg_echo('gcconnex_profile:gc_skills');
            break;
        case 'languages':
            $field = elgg_echo('gcconnex_profile:langs');
            break;
        case 'portfolio':
            $field = elgg_echo('gcconnex_profile:portfolio');
            break;
    }

    echo '<div class="panel">';
    echo'<div class="panel-body profile-title">';
    echo '<h2 class="pull-left">' . $title . '</h2>'; // create the profile section title

    echo '</div>';
     // create the profile section wrapper div for css styling
    echo '<div id="edit-' . $section . '" tabindex="-1" class="gcconnex-profile-section-wrapper panel-body gcconnex-' . $section . '">';
}


function tidypics_read_only($page) {

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

    $baseReadOnly = elgg_get_plugins_path() . 'gcconnex_read_only/pages/photos';

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
			require "$baseReadOnly/all.php";
			break;

		case "owned":  // albums owned by container entity
		case "owner":
			require "$baseReadOnly/owner.php";
			break;

		case "friends": // albums of friends
			require "$baseReadOnly/friends.php";
			break;

		case "group": // albums of a group
			require "$baseReadOnly/owner.php";
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

function file_read_only_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$file_dir = elgg_get_plugins_path() . 'file/pages/file';
	$file_dir_readonly = elgg_get_plugins_path() . 'gcconnex_read_only/pages/file';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			file_register_toggle();
			include "$file_dir_readonly/owner.php";
			break;
		case 'friends':
			file_register_toggle();
			include "$file_dir_readonly/friends.php";
			break;
		case 'view':
			elgg_push_context('view_file');
			set_input('guid', $page[1]);
			include "$file_dir/view.php";
			break;
		case 'add':
			include "$file_dir/upload.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$file_dir/edit.php";
			break;
		case 'search':
			file_register_toggle();
			include "$file_dir/search.php";
			break;
		case 'group':
			file_register_toggle();
			include "$file_dir_readonly/owner.php";
			break;
		case 'all':
			file_register_toggle();
			include "$file_dir_readonly/world.php";
			break;
		case 'download':
			set_input('guid', $page[1]);
			include "$file_dir/download.php";
			break;
		default:
			return false;
	}
	return true;
}

function decommission_message() {

    echo "<div class='panel panel-default'>
            <div class='panel-body'>
            <div class='col-md-4'>
                <img src='" . $site_url . "/mod/gcconnex_read_only/graphics/GCconnex_Decom_Final_Banner.png' alt='" . elgg_echo('readonly:message') . "' />
            </div>
            <div class='col-md-8'>
            <div class='mrgn-lft-lg'>
                <div class='mrgn-bttm-md h3 mrgn-tp-0'>" . elgg_echo('readonly:message') . "</div>
                <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:1') . "</div>
                <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:2') . "</div>
                <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:3') . "</div>
                <div>" . elgg_echo('readonly:message:4') . "</div>
            </div>
        </div>
    </div>
</div>";
}