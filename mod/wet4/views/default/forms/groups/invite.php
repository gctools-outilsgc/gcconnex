<?php
/**
 * Elgg groups plugin
 *
 * @package ElggGroups
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels
 * Author: GCTools Team
 */
$group = elgg_extract("entity", $vars, elgg_get_page_owner_entity());
$invite_site_members = elgg_extract("invite", $vars, "no");
$invite_circle = elgg_extract("invite_circle", $vars, "no");
$invite_email = elgg_extract("invite_email", $vars, "no");
$invite_csv = elgg_extract("invite_csv", $vars, "no");

$owner = $group->getOwnerEntity();
$forward_url = $group->getURL();

$tabs = false;

$friends = elgg_get_logged_in_user_entity()->getFriends(array("limit" => false));
if (!empty($friends)) {
	$toggle_content = "<span>" . elgg_echo("group_tools:group:invite:friends:select_all") . "</span>";
	$toggle_content .= "<span class='hidden wb-invisible'>" . elgg_echo("group_tools:group:invite:friends:deselect_all") . "</span>";

	//$friendspicker = elgg_view("output/url", array("text" => $toggle_content, "href" => "javascript:void(0);", "onclick" => "group_tools_toggle_all_friends();", "id" => "friends_toggle", "class" => "float-alt elgg-button elgg-button-action"));
	$friendspicker .= elgg_view('input/friendspicker', array('entities' => $friends, 'name' => 'user_guid', 'highlight' => 'all'));
} else {
	$friendspicker = elgg_echo('groups:nofriendsatall');
}

// which options to show
if (in_array("yes", array($invite_site_members, $invite_circle, $invite_email, $invite_csv))) {
	$tabs = array(
		"friends" => array(
			"text" => elgg_echo("friends"),
			"href" => "#",
			"rel" => "friends",
			"priority" => 200,
			"onclick" => "group_tools_group_invite_switch_tab(\"friends\");",
			"selected" => true
		)
	);

	// invite friends
	$form_data = "<div id='group_tools_group_invite_friends'>";
	$form_data .= $friendspicker;

    //fix an odd bug where if a user doesn't have any colleagues, the form will break
    if(elgg_get_logged_in_user_entity()->getFriends(array('count'=>true,)) > 0){
        $form_data .= "</div></div></div></div>";
    } else {
        $form_data .= '</div>';
    }

	//invite all site members
	if ($invite_site_members == "yes") {
		$tabs["users"] = array(
			"text" => elgg_echo("group_tools:group:invite:users"),
			"href" => "#",
			"rel" => "users",
			"priority" => 300,
			"onclick" => "group_tools_group_invite_switch_tab(\"users\");"
		);

		$form_data .= "<div id='group_tools_group_invite_users' class='mbm'>";
		$form_data .= "<div><label for='group_tools_group_invite_autocomplete_autocomplete'>" . elgg_echo("group_tools:group:invite:users:description") . "</label></div>";
		$form_data .= elgg_view("input/group_invite_autocomplete", array("name" => "user_guid",
																			"id" => "group_tools_group_invite_autocomplete",
																			"group_guid" => $group->getGUID(),
																			"relationship" => "site"));
		if (elgg_is_admin_logged_in()) {
			$form_data .= elgg_view("input/checkbox", array("name" => "all_users", "id" => "all_users", "value" => "yes"));
			$form_data .= '<label for="all_users">'.elgg_echo("group_tools:group:invite:users:all").'</label>';
		}

		$form_data .= "</div>";

	}

	if ($invite_circle == "yes") {
		$tabs["circle"] = array(
			"text" => elgg_echo("friends:collections"),
			"href" => "#",
			"rel" => "users",
			"priority" => 400,
			"onclick" => "group_tools_group_invite_switch_tab(\"circle\");"
		);

		$form_data .= "<div id='group_tools_group_invite_circle' class='mbm'>";
		$form_data .= "<p><label for='user_guid[]'>".elgg_echo("collections_circle_selection")."</label></p>";

		$content = get_user_access_collections(elgg_get_logged_in_user_guid());
		$collection_id = get_user_access_collections(elgg_get_logged_in_user_guid());

		$form_data .= '<select class="form-control" id="user_guid[]" name="user_guid[]">
				 <option value="">---</option>';

		foreach ($content as $key => $collection) {
			$collections = get_members_of_access_collection($collection->id, true);
			$form_data .= "<option value=";
			$coll_members = array();

				foreach ($collections as $key => $value) {
					$name = get_user($value);
					$coll_members[] = $name->guid;
				}

			$form_data .= implode(',', $coll_members);

			if ($collection->id == $collection_id){
				$form_data .= ' selected="selected"';
			}

			$form_data .='> ';
			$form_data .= ' '.$collection->name.'</option>';
			$form_data .= '<br>';
		}
		$form_data .= '</select>';
		$form_data .= "</div>";
	}

	// invite by email
	if ($invite_email == "yes") {

        $tabs["email"] = array(
			"text" => elgg_echo("group_tools:group:invite:email"),
			"href" => "#",
			"rel" => "users",
			"priority" => 500,
			"onclick" => "group_tools_group_invite_switch_tab(\"email\");"
		);

		elgg_load_css('multiple-emails');
		elgg_load_js('multiple-emails');

		$form_data .= "<div id='group_tools_group_invite_email' class='hidden wb-invisible mbm'>";
		$form_data .= "<div><label for='group_tools_group_invite_autocomplete_email_autocomplete'>" . elgg_echo("group_tools:group:invite:email:description") . "</label></div>";
		$form_data .= elgg_view("input/text", array("name" => "user_emails",
																			"id" => "group_tools_group_invite_autocomplete_email",
																			"group_guid" => $group->getGUID(),
																			"relationship" => "email"));

		$form_data .= "<script>
			$('#group_tools_group_invite_autocomplete_email').multiple_emails();
			$('.elgg-form-groups-invite').keydown(function(e){
				if( $(e.target).hasClass('multiple_emails-input') && e.keyCode == 13 ){ e.preventDefault(); }
			});
		</script>";
		
		$form_data .= "</div>";

    }

	//invite by cvs upload
	if ($invite_csv == "yes") {
		$tabs["csv"] = array(
			"text" => elgg_echo("group_tools:group:invite:csv"),
			"href" => "#",
			"rel" => "users",
			"priority" => 600,
			"onclick" => "group_tools_group_invite_switch_tab(\"csv\");"
		);

		$form_data .= "<div id='group_tools_group_invite_csv' class='hidden wb-invisible mbm'>";
		$form_data .= "<div>" . elgg_echo("group_tools:group:invite:csv:description") . "</div>";
		$form_data .= elgg_view("input/file", array("name" => "csv"));
		$form_data .= "</div>";
	}

} else {
	// only friends
	$form_data = $friendspicker;
}

// optional text
$form_data .= elgg_view_module("aside", elgg_echo("group_tools:group:invite:text"), elgg_view("input/longtext", array("name" => "comment")), array('class' => 'mrgn-tp-lg'));

// renotify existing invites
if ($group->canEdit()) {
	$form_data .= "<div class='mrgn-bttm-sm'>";
	$form_data .= "<input type='checkbox' name='resend' value='yes' />";
	$form_data .= "&nbsp;" . elgg_echo("group_tools:group:invite:resend");
	$form_data .= "</div>";
}

// build tabs
if (!empty($tabs)) {
	foreach ($tabs as $name => $tab) {
		$tab["name"] = $name;

		elgg_register_menu_item("filter", $tab);
	}
	echo elgg_view_menu("filter", array("sort_by" => "priority"));
    echo '<div class="mrgn-bttm-md"></div>';
}

// show form
echo $form_data;

?>

<script>


             $('.noSubmit').keypress(function (e) {
                 if (e.keyCode == 13) {

                     if ($('#group_tools_group_invite_autocomplete_email').val() == '') {
                        //submit form if nothing entered in text box
                     } else {

                         var emails = $('#group_tools_group_invite_autocomplete_email').val().split(',');


                         for (var i = 0; i < emails.length; i++) {
                             var inputs = $('.group_tools_group_invite_autocomplete_autocomplete_result input');

                             //make sure email is not already added to list
                             for (var t = 0; t < inputs.length; t++) {
                                 if (inputs[t].getAttribute("value") == $.trim(emails[i])) {
                                     emails[i] = '';
                                 }
                             }

                             var blankTest = $.trim(emails[i]);

                             //remove blank entries and add emails to list
                             if (blankTest != '') {

                                 var email = '<div class="group_tools_group_invite_autocomplete_autocomplete_result elgg-discover_result elgg-discover"><input type="hidden" value="' + $.trim(emails[i]) + '" name="user_guid_email[]">' + $.trim(emails[i]) + '<i class="fa fa-trash-o fa-lg icon-unsel mrgn-lft-sm elgg-icon-delete-alt"><span class="wb-inv">Delete this</span></i></div>';

                                 $('#group_tools_group_invite_autocomplete_email_autocomplete_results').append(email);
                             }
                         }

                         //reset textbox
                         $('#group_tools_group_invite_autocomplete_email').val('');

                         e.preventDefault();
                         return false;
                     }
                }

             });

             $('#group_tools_group_invite_email .elgg-icon-delete-alt').live("click", function () {
			    $(this).parent('div').remove();
             });

             $('.elgg-button-submit').live("click", function () {

                 if ($('td input:checked').attr('checked', 'checked')) {
                     $('td input:checked').remove();
                 }
             });


</script>

<?php

// show buttons
echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array('name' => 'forward_url', 'value' => $forward_url));
echo elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->guid));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('invite')));
if (elgg_is_admin_logged_in()) {
	echo elgg_view("input/submit", array('name' => 'submit', "value" => elgg_echo("group_tools:add_users"), "onclick" => "return confirm(\"" . elgg_echo("group_tools:group:invite:add:confirm") . "\");"));
}
echo '</div>';

?>
<script type="text/javascript">

    $('#group_tools_group_invite_email').hide();
	$('#group_tools_group_invite_circle').hide();
    $('#group_tools_group_invite_users').hide();
	function group_tools_group_invite_switch_tab(tab) {
		$('#invite_to_group li').removeClass('elgg-state-selected');

		$('#invite_to_group li.elgg-menu-item-' + tab).addClass('elgg-state-selected');

		switch (tab) {
			case "users":
				$('#group_tools_group_invite_friends').hide();
				$('#group_tools_group_invite_email').hide();
				$('#group_tools_group_invite_csv').hide();
				$('#group_tools_group_invite_circle').hide();

				$('#group_tools_group_invite_users').show();
				break;
			case "circle":
				$('#group_tools_group_invite_friends').hide();
				$('#group_tools_group_invite_email').hide();
				$('#group_tools_group_invite_csv').hide();
				$('#group_tools_group_invite_users').hide();

				$('#group_tools_group_invite_circle').show();
				break;
			case "email":
				$('#group_tools_group_invite_friends').hide();
				$('#group_tools_group_invite_users').hide();
				$('#group_tools_group_invite_csv').hide();
				$('#group_tools_group_invite_circle').hide();

				$('#group_tools_group_invite_email').removeClass('hidden wb-invisible').show();;
				break;
			case "csv":
				$('#group_tools_group_invite_friends').hide();
				$('#group_tools_group_invite_users').hide();
				$('#group_tools_group_invite_email').hide();
				$('#group_tools_group_invite_circle').hide();

				$('#group_tools_group_invite_csv').show();
				break;
			default:
				$('#group_tools_group_invite_users').hide();
				$('#group_tools_group_invite_email').hide();
				$('#group_tools_group_invite_csv').hide();
				$('#group_tools_group_invite_circle').hide();

				$('#group_tools_group_invite_friends').show();
				break;
		}
	}

	function group_tools_toggle_all_friends() {

		if ($('#friends_toggle span:first').is(':visible')) {
			$('#friends-picker1 input[type="checkbox"]').attr("checked", "checked");
		} else {
			$('#friends-picker1 input[type="checkbox"]').removeAttr("checked");
		}

		$('#friends_toggle span').toggle();
	}
</script>
