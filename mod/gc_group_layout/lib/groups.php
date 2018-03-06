<?php
/**
 * Groups function library
 */

/**
 * List all groups
 */
function groups_handle_all_page() {
	$display_subgroups = elgg_get_plugin_setting('display_subgroups', 'au_subgroups');
	$db_prefix = elgg_get_config('dbprefix');

	// all groups doesn't get link to self
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('groups'));

	if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
		elgg_register_title_button();
	}


	$gsa_tab = get_input('gsa');
	if ($gsa_tab) {

		switch ($gsa_tab) {

			case 'discussion':
				$options = array(
					'type' => 'object',
					'subtype' => 'groupforumtopic',
					'no_results' => elgg_echo('discussion:none'),
				);

				$content = elgg_list_entities($options);

				break;

			case 'groups':
				$options = array(
					'type' => 'group',
					'inverse_relationship' => false,
					'no_results' => elgg_echo('groups:none'),
				);

				$content = elgg_list_entities($options);

				break;

			default: // cyu - in theory this should never invoke
				break;
		}

	} else {

		$selected_tab = get_input('filter', 'newest');

		switch ($selected_tab) {
			case 'popular':
				$options = array(
					'type' => 'group',
					'relationship' => 'member',
					'inverse_relationship' => false,
					'full_view' => false,
					'no_results' => elgg_echo('groups:none'),
				);

				if ($display_subgroups != 'yes') {
					$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = 'au_subgroup_of' )");
				}

				$content = elgg_list_entities_from_relationship_count($options);
				break;
			case 'discussion':
				$options = array(
					'type' => 'object',
					'subtype' => 'groupforumtopic',
					'order_by' => 'e.last_action desc',
					'limit' => 40,
					'full_view' => false,
					'no_results' => elgg_echo('discussion:none'),
				);

				if ($display_subgroups != 'yes') {
					$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = 'au_subgroup_of' )");
				}

				$content = elgg_list_entities($options);
				break;
			case 'newest':
			default:
				$options = array(
					'type' => 'group',
					'full_view' => false,
					'no_results' => elgg_echo('groups:none'),
				);

				if ($display_subgroups != 'yes') {
					$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = 'au_subgroup_of' )");
				}

				$content = elgg_list_entities($options);
				break;
		}

	} // end if clause

	$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab));

	$sidebar = elgg_view('groups/sidebar/find');
	$sidebar .= elgg_view('groups/sidebar/featured');

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => $filter,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page(elgg_echo('groups:all'), $body);
}

function groups_search_page() {
	elgg_push_breadcrumb(elgg_echo('search'));

	$tag = get_input("tag");
	$display_query = _elgg_get_display_query($tag);
	$title = elgg_echo('groups:search:title', array($display_query));

	// groups plugin saves tags as "interests" - see groups_fields_setup() in start.php
	$params = array(
		'metadata_name' => 'interests',
		'metadata_value' => $tag,
		'type' => 'group',
		'full_view' => false,
		'no_results' => elgg_echo('groups:search:none'),
	);
	$content = elgg_list_entities_from_metadata($params);

	$sidebar = elgg_view('groups/sidebar/find');
	//$sidebar .= elgg_view('groups/sidebar/featured');

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => false,
		'title' => $title,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * List owned groups
 */
function groups_handle_owned_page() {

    set_context('my_groups');
	$page_owner = elgg_get_page_owner_entity();
    $selected_tab = get_input("filter");

	if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
		$title = elgg_echo('groups:owned');

	} else {
		$title = elgg_echo('groups:owned:user', array($page_owner->name));
	}
	elgg_push_breadcrumb($title);

	if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
        elgg_push_context('groups');
		elgg_register_title_button();
        elgg_pop_context();
	}

	$dbprefix = elgg_get_config('dbprefix');
	$content = elgg_list_entities(array(
		'type' => 'group',
		'owner_guid' => elgg_get_page_owner_guid(),
		//'joins' => array("JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid"),
		//'order_by' => 'ge.name ASC',
		'full_view' => false,
		'no_results' => elgg_echo('groups:none'),
		'distinct' => false,
        'limit' => 0,
	));
$filter = elgg_view("groups/group_sort_menu", array("selected" => $selected_tab));
$sidebar = elgg_view("groups/sidebar/find");
$sidebar .= elgg_view("groups/sidebar/featured");

	$params = array(
		'content' => $content,
		'title' => $title,
        "sidebar" => $sidebar,
		'filter' => $filter,
	);
	$body = elgg_view_layout('content',  $params);
    elgg_pop_context();
	echo elgg_view_page($title, $body);
}

/**
 * List groups the user is memober of
 */
function groups_handle_mine_page() {
    set_context('my_groups');
	$page_owner = elgg_get_page_owner_entity();

	if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
		$title = elgg_echo('groups:yours');
	} else {
		$title = elgg_echo('groups:user', array($page_owner->name));
	}
	elgg_push_breadcrumb($title);

	if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
        elgg_push_context('groups');
		elgg_register_title_button();
        elgg_pop_context();
	}

	$dbprefix = elgg_get_config('dbprefix');

	$content = elgg_list_entities_from_relationship(array(
		'type' => 'group',
		'relationship' => 'member',
		'relationship_guid' => elgg_get_page_owner_guid(),
		'inverse_relationship' => false,
		'full_view' => false,

		'joins' => array("JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid"),
		'order_by' => 'ge.name ASC',
		'no_results' => elgg_echo('groups:none'),
        'limit' => false, //this should work but it doesn't
	));

    $sidebar = elgg_view('groups/sidebar/find');
    $filter = elgg_view("groups/group_sort_menu", array("selected" => $selected_tab));
   // $sidebar = elgg_view('groups/sidebar/suggested');
    $sidebar .= elgg_view('groups/sidebar/featured');

	$params = array(
		'content' => $content,
		'title' => $title,
        "sidebar" => $sidebar,
		'filter' => $filter,
	);
	$body = elgg_view_layout('content', $params);
    elgg_pop_context();
	echo elgg_view_page($title, $body);
}

/**
 * Create or edit a group
 *
 * @param string $page
 * @param int $guid
 */
function groups_handle_edit_page($page, $guid = 0) {
	elgg_gatekeeper();

	elgg_require_js('elgg/groups/edit');

	if ($page == 'add') {
		elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
		$title = elgg_echo('groups:add');
		elgg_push_breadcrumb($title);
		if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
			$content = elgg_view('groups/edit');
		} else {
			$content = elgg_echo('groups:cantcreate');
		}
	} else {
		$title = elgg_echo("groups:edit");
		$group = get_entity($guid);

		if (elgg_instanceof($group, 'group') && $group->canEdit()) {
			elgg_set_page_owner_guid($group->getGUID());
			//elgg_push_breadcrumb($group->name, $group->getURL());
			//elgg_push_breadcrumb($title);
			$content = elgg_view("groups/edit", array('entity' => $group));
		} else {
			$content = elgg_echo('groups:noaccess');
		}
	}

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group invitations for a user
 */
function groups_handle_invitations_page() {
	elgg_gatekeeper();

	$username = get_input('username');
	if ($username) {
		$user = get_user_by_username($username);
		elgg_set_page_owner_guid($user->guid);
	} else {
		$user = elgg_get_logged_in_user_entity();
		elgg_set_page_owner_guid($user->guid);
	}

	if (!$user || !$user->canEdit()) {
		register_error(elgg_echo('noaccess'));
		forward('');
	}

	$title = elgg_echo('groups:invitations');
	elgg_push_breadcrumb($title);

	$content = elgg_view('groups/invitationrequests');

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group profile page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_profile_page($guid) {
	elgg_set_page_owner_guid($guid);

	// turn this into a core function
	global $autofeed;
	$autofeed = true;
	$lang = get_current_language();
	$title = gc_explode_translation($title,$lang);

	elgg_push_context('group_profile');

	elgg_entity_gatekeeper($guid, 'group');

	$group = get_entity($guid);

	elgg_push_breadcrumb($title);

	groups_register_profile_buttons($group);

	$content = elgg_view('groups/profile/layout', array('entity' => $group));
	$sidebar_value = $group->getPrivateSetting('group_tools:cleanup:menu');

	if($sidebar_value == 'no'){
		$sidebar = elgg_view('groups/sidebar/sidebar', array('entity' => $group));
	}
	
	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'title' => $title,
	);
	$body = elgg_view_layout('one_sidebar', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group activity page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_activity_page($guid) {

	elgg_entity_gatekeeper($guid, 'group');

	elgg_set_page_owner_guid($guid);

	elgg_group_gatekeeper();

	$group = get_entity($guid);

	$title = elgg_echo('groups:activity');

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb($title);

	$db_prefix = elgg_get_config('dbprefix');

	$content = elgg_list_river(array(
		'wheres' => array(
			"(oe.container_guid = $group->guid OR te.container_guid = $group->guid)",
		),
		'no_results' => elgg_echo('groups:activity:none'),
	));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group members page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_members_page($guid) {

    elgg_push_context('groups_members');
	elgg_entity_gatekeeper($guid, 'group');
	$lang = get_current_language();
	$group = get_entity($guid);

	elgg_set_page_owner_guid($guid);

	elgg_group_gatekeeper();

	$title = elgg_echo('groups:members:title', array(gc_explode_translation($group->title,$lang)));

	elgg_push_breadcrumb(gc_explode_translation($group->title,$lang), $group->getURL());
	elgg_push_breadcrumb(elgg_echo('groups:members'));

	$db_prefix = elgg_get_config('dbprefix');
	$content = elgg_list_entities_from_relationship(array(
		'relationship' => 'member',
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'type' => 'user',
		'limit' => 0,
		'joins' => array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid"),
		'order_by' => 'u.name ASC',
	));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);
    elgg_pop_context();
	echo elgg_view_page($title, $body);
}

/**
 * Invite users to a group
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_invite_page($guid) {
	elgg_gatekeeper();

	elgg_set_page_owner_guid($guid);

	$title = elgg_echo('groups:invite:title');

	$group = get_entity($guid);
	if (!elgg_instanceof($group, 'group') || !$group->canEdit()) {
		register_error(elgg_echo('groups:noaccess'));
		forward(REFERER);
	}

	$content = elgg_view_form('groups/invite', array(
		'id' => 'invite_to_group',
		'class' => 'elgg-form-alt mtm',
	), array(
		'entity' => $group,
	));

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb(elgg_echo('groups:invite'));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Manage requests to join a group
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_requests_page($guid) {

	elgg_gatekeeper();

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);
	if (!elgg_instanceof($group, 'group') || !$group->canEdit()) {
		register_error(elgg_echo('groups:noaccess'));
		forward(REFERER);
	}

	$title = elgg_echo('groups:membershiprequests');

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb($title);

	$requests = elgg_get_entities_from_relationship(array(
		'type' => 'user',
		'relationship' => 'membership_request',
		'relationship_guid' => $guid,
		'inverse_relationship' => true,
		'limit' => 0,
	));
	$content = elgg_view('groups/membershiprequests', array(
		'requests' => $requests,
		'entity' => $group,
	));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Registers the buttons for title area of the group profile page
 *
 * @param ElggGroup $group
 */
function groups_register_profile_buttons($group) {

	$actions = array();

	// group owners
	if ($group->canEdit()) {
		// edit and invite
		$url = elgg_get_site_url() . "groups/edit/{$group->getGUID()}";
		$actions[$url] = 'groups:edit';
		$url = elgg_get_site_url() . "groups/invite/{$group->getGUID()}";
		$actions[$url] = 'groups:invite';
	}

	// group members
	if ($group->isMember(elgg_get_logged_in_user_entity())) {
		if ($group->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
			// leave
			$url = elgg_get_site_url() . "action/groups/leave?group_guid={$group->getGUID()}";
			$url = elgg_add_action_tokens_to_url($url);
			$actions[$url] = 'groups:leave';
		}
		
		if( strpos(elgg_get_site_entity()->name, 'collab') !== false ){
			$url = elgg_get_site_url() . "groups/stats/{$group->getGUID()}";
			$actions[$url] = 'groups:stats';
		}
	} elseif (elgg_is_logged_in()) {
		// join - admins can always join.
		$url = elgg_get_site_url() . "action/groups/join?group_guid={$group->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		if ($group->isPublicMembership() || $group->canEdit()) {
			$actions[$url] = 'groups:join';
		} else {
			// request membership
			$actions[$url] = 'groups:joinrequest';
		}
	}

	if ($actions) {
		foreach ($actions as $url => $text) {
			elgg_register_menu_item('group_ddb', array(
				'name' => $text,
				'href' => $url,
				'text' => elgg_echo($text),
				'link_class' => 'elgg-button elgg-button-action',
			));
		}
	}

}

/**
 * Prepares variables for the group edit form view.
 *
 * @param mixed $group ElggGroup or null. If a group, uses values from the group.
 * @return array
 */
function groups_prepare_form_vars($group = null) {
	$values = array(
		'name' => '',
		'name2' => '',
		'membership' => ACCESS_PUBLIC,
		'vis' => ACCESS_PUBLIC,
		'guid' => null,
		'entity' => null,
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'content_access_mode' => ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED
	);

	// handle customizable profile fields
	$fields = elgg_get_config('group');

	if ($fields) {
		foreach ($fields as $name => $type) {
			$values[$name] = '';
		}
	}

	// handle tool options
	$tools = elgg_get_config('group_tool_options');
	if ($tools) {
		foreach ($tools as $group_option) {
			$option_name = $group_option->name . "_enable";
			$values[$option_name] = $group_option->default_on ? 'yes' : 'no';
		}
	}

	// get current group settings
	if ($group) {
		foreach (array_keys($values) as $field) {
			if (isset($group->$field)) {
				$values[$field] = $group->$field;
			}
		}

		if ($group->access_id != ACCESS_PUBLIC && $group->access_id != ACCESS_LOGGED_IN) {
			// group only access - this is done to handle access not created when group is created
			$values['vis'] = ACCESS_PRIVATE;
		} else {
			$values['vis'] = $group->access_id;
		}

		// The content_access_mode was introduced in 1.9. This method must be
		// used for backwards compatibility with groups created before 1.9.
		$values['content_access_mode'] = $group->getContentAccessMode();

		$values['entity'] = $group;
	}

	// get any sticky form settings
	if (elgg_is_sticky_form('groups')) {
		$sticky_values = elgg_get_sticky_values('groups');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('groups');

	return $values;
}

/**
 * View stats for a group
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_stats_page($guid) {

	elgg_gatekeeper();

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);
	if (!elgg_instanceof($group, 'group') || strpos(elgg_get_site_entity()->name, 'collab') == false) {
		register_error(elgg_echo('groups:noaccess'));
		forward(REFERER);
	}

	$title = elgg_echo('groups:stats');
	$lang = get_current_language();

	elgg_push_breadcrumb(gc_explode_translation($group->name, $lang), $group->getURL());
	elgg_push_breadcrumb($title);

	ob_start(); ?>

    <script src="//code.highcharts.com/highcharts.js"></script>
    <script src="//code.highcharts.com/modules/exporting.js"></script>
    <script src="//code.highcharts.com/modules/data.js"></script>
    <script src="//code.highcharts.com/modules/drilldown.js"></script>
    <script src="//highcharts.github.io/export-csv/export-csv.js"></script>
    <script>var lang = '<?php echo get_current_language(); ?>';</script>
    <script>var siteUrl = '<?php echo elgg_get_site_url(); ?>';</script>
    <script>var group = '<?php echo $guid; ?>';</script>
    <script>
        Date.prototype.niceDate = function() {
            if(lang == "fr"){
                var months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
                var mm = this.getMonth();
                var dd = this.getDate();
                var yy = this.getFullYear();
                return dd + ' ' + months[mm] + ' ' + yy;
            } else {
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                var mm = this.getMonth();
                var dd = this.getDate();
                var yy = this.getFullYear();
                return months[mm] + ' ' + dd + ', ' + yy;
            }
        };

        String.prototype.capitalizeFirstLetter = function() {
            return this.charAt(0).toUpperCase() + this.slice(1);
        }

        function SortRegistrations(a, b){
            return (a[0] - b[0]);
        }

        function SortByCount(a, b){
            return (b[1] - a[1]);
        }

        function SortByName(a, b){
            var one = (a.name != null) ? a.name.toLowerCase().replace(/é/g, 'e').replace(/è/g, 'e').replace(/î/g, 'i') : "";
            var two = (b.name != null) ? b.name.toLowerCase().replace(/é/g, 'e').replace(/è/g, 'e').replace(/î/g, 'i') : "";
            if(one < two) return -1;
            if(one > two) return 1;
            return 0;
        }

        function SortInstitutionByName(a, b){
            var one = (a[0] != null) ? a[0].toLowerCase().replace(/é/g, 'e').replace(/è/g, 'e').replace(/î/g, 'i') : "";
            var two = (b[0] != null) ? b[0].toLowerCase().replace(/é/g, 'e').replace(/è/g, 'e').replace(/î/g, 'i') : "";
            if(one < two) return -1;
            if(one > two) return 1;
            return 0;
        }
    </script>
<?php if(get_current_language() == "fr"): ?>
    <script>
        Highcharts.setOptions({
            lang: {
                months: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
                weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                shortMonths: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Déc'],
                decimalPoint: ',',
                downloadPNG: 'Télécharger en image PNG',
                downloadJPEG: 'Télécharger en image JPEG',
                downloadPDF: 'Télécharger en document PDF',
                downloadSVG: 'Télécharger en document Vectoriel',
                exportButtonTitle: 'Export du graphique',
                loading: 'Chargement en cours...',
                printButtonTitle: 'Imprimer le graphique',
                resetZoom: 'Réinitialiser le zoom',
                resetZoomTitle: 'Réinitialiser le zoom au niveau 1:1',
                thousandsSep: ' ',
                decimalPoint: ',',
                printChart: 'Imprimer le graphique',
                downloadCSV: 'Télécharger en CSV',
                downloadXLS: 'Télécharger en XLS',
                viewData: 'Afficher la table des données'
            }
        });
    </script>
<?php endif; ?>
    <style>
    .chart {
        width: 100%;
        min-width: 100%; 
        max-width: 100%; 
        margin: 0 auto;
    }
    .chart .loading {
        padding-top: 10%;
        display: block;
        font-size: 2em;
        text-align: center;
    }
    @media (max-width: 480px) { 
        .nav-tabs > li {
            float:none;
        }
    }
    </style>

	<div class="chart" id="groupsjoinedChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

    <script>
        $(function () {
            $.getJSON(siteUrl + 'services/api/rest/json/?method=group.stats&type=groupsjoined&group=' + group + '&lang=' + lang, function (data) {
            	var dates = {};
                var users = {};
                var groupsjoined = [];
                $.each(data.result, function(key, value){
                    var date = new Date(value[0] * 1000);
                    date.setHours(0, 0, 0, 0);
                    var dateString = date.getTime();
                    dates[dateString] = (dates[dateString] ? dates[dateString] + 1 : 1);
                    if( users[dateString] ){
                    	users[dateString] = users[dateString] + value[1] + "<br>";
                    } else {
                    	users[dateString] = "";
                    	users[dateString] = users[dateString] + value[1] + "<br>";
                    }
                });
                $.each(dates, function(key, value){
                    key = parseInt(key);
                    groupsjoined.push([key, value, new Date(key).niceDate(), users[key]]);
                });
                groupsjoined.sort();

                Highcharts.chart('groupsjoinedChart', {
                    chart: {
                        zoomType: 'x'
                    },
                    title: {
                        text: '<?php echo elgg_echo("gccollab_stats:usersjoined:title"); ?>'
                    },
                    subtitle: {
                        text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                    },
                    xAxis: {
                        type: 'datetime'
                    },
                    yAxis: {
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:usersjoined:amount"); ?>'
                        },
                        min: 0
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                ]
                            },
                            marker: {
                                radius: 2
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1
                                }
                            },
                            threshold: null
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + groupsjoined[this.series.data.indexOf(this.point)][2] + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + groupsjoined[this.series.data.indexOf(this.point)][1]+ '<br /><b><?php echo elgg_echo("gccollab_stats:users:title"); ?></b> ' + groupsjoined[this.series.data.indexOf(this.point)][3];
                        }
                    },
                    series: [{
                        type: 'area',
                        name: '<?php echo elgg_echo("gccollab_stats:groupsjoined:title"); ?>',
                        data: groupsjoined
                    }]
                });
        	});
        });
    </script>

    <br>

    <div class="chart" id="allMembers" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

    <script>
        $(function () {
            $.getJSON(siteUrl + 'services/api/rest/json/?method=group.stats&group=' + group + '&type=users&lang=' + lang, function (data) {
                var allMembers = [];
                var allMembersCount = 0, unknownCount = 0;
                $.each(data.result, function(key, value) {
                    if(key != 'public_servant' && key != ''){
                        allMembers.push([key.capitalizeFirstLetter(), value]);
                    } else {
                        unknownCount += value;
                    }
                    allMembersCount += value;
                });
                if(unknownCount > 0){ allMembers.push(['<?php echo elgg_echo('gccollab_stats:unknown'); ?>', unknownCount]); }
                allMembers.sort(SortByCount);

                Highcharts.chart('allMembers', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: '<?php echo elgg_echo("gccollab_stats:types:title"); ?> (' + allMembersCount + ')'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                        }

                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y}'
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                        pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                    },
                    series: [{
                        name: '<?php echo elgg_echo("gccollab_stats:membertype"); ?>',
                        colorByPoint: true,
                        data: allMembers
                    }]
                });
            });
        });
    </script>

    <?php

    $content = ob_get_clean();

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);
	$body = str_replace('col-md-8', 'col-md-12', $body);

	echo elgg_view_page($title, $body);
}
