<?php
/**
 * Elgg groups plugin
 *
 * @package ElggGroups
 */

$group = elgg_extract("entity", $vars, elgg_get_page_owner_entity());
$invite_site_members = elgg_extract("invite", $vars, "no");
$invite_email = elgg_extract("invite_email", $vars, "no");;
$invite_csv = elgg_extract("invite_csv", $vars, "no");;

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
if (in_array("yes", array($invite_site_members, $invite_email, $invite_csv))) {
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
	$form_data .= "</div></div></div></div>";

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
		$form_data .= "<div>" . elgg_echo("group_tools:group:invite:users:description") . "</div>";
		$form_data .= elgg_view("input/group_invite_autocomplete", array("name" => "user_guid",
																			"id" => "group_tools_group_invite_autocomplete",
																			"group_guid" => $group->getGUID(),
																			"relationship" => "site"));
		if (elgg_is_admin_logged_in()) {
			$form_data .= elgg_view("input/checkbox", array("name" => "all_users", "value" => "yes"));
			$form_data .= elgg_echo("group_tools:group:invite:users:all");
		}


		
		$form_data .= "</div>";


	}
	
	// invite by email
	if ($invite_email == "yes") {
		$tabs["email"] = array(
			"text" => elgg_echo("group_tools:group:invite:email"),
			"href" => "#",
			"rel" => "users",
			"priority" => 400,
			"onclick" => "group_tools_group_invite_switch_tab(\"email\");"
		);
		
		$form_data .= "<div id='group_tools_group_invite_email' class='mbm'>";
		$form_data .= "<div>" . elgg_echo("group:invite:email") . "</div>";
		$form_data .= elgg_view("input/text", array("name" => "user_guid",
																			"id" => "group_tools_group_invite_autocomplete_email",
																			"group_guid" => $group->getGUID(),
																			"relationship" => "email",
                                                                            'class' => 'noSubmit'));

        $form_data .= '<div id="group_tools_group_invite_autocomplete_email_autocomplete_results"> <div class="group_tools_group_invite_autocomplete_autocomplete_result elgg-discover_result elgg-discover"><input type="hidden" value="" name="user_guid_email[]"></div>  </div>';

		$form_data .= "</div>";

        //<div class="group_tools_group_invite_autocomplete_autocomplete_result elgg-discover_result elgg-discover"><input type="hidden" value="etan154@gmail.com" name="user_guid_email[]">etan154@gmail.com<i class="fa fa-trash-o fa-lg icon-unsel mrgn-lft-sm elgg-icon-delete-alt"><span class="wb-inv">Delete this</span></i></div> 
	}
	
	//invite by cvs upload
	if ($invite_csv == "yes") {
		$tabs["csv"] = array(
			"text" => elgg_echo("group_tools:group:invite:csv"),
			"href" => "#",
			"rel" => "users",
			"priority" => 500,
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

    $('#group_tools_group_invite_users').hide();
	function group_tools_group_invite_switch_tab(tab) {
		$('#invite_to_group li').removeClass('elgg-state-selected');

		$('#invite_to_group li.elgg-menu-item-' + tab).addClass('elgg-state-selected');

		switch (tab) {
			case "users":
				$('#group_tools_group_invite_friends').hide();
				$('#group_tools_group_invite_email').hide();
				$('#group_tools_group_invite_csv').hide();
				
				$('#group_tools_group_invite_users').show();
				break;
			case "email":
				$('#group_tools_group_invite_friends').hide();
				$('#group_tools_group_invite_users').hide();
				$('#group_tools_group_invite_csv').hide();
				
				$('#group_tools_group_invite_email').show();
				break;
			case "csv":
				$('#group_tools_group_invite_friends').hide();
				$('#group_tools_group_invite_users').hide();
				$('#group_tools_group_invite_email').hide();
				
				$('#group_tools_group_invite_csv').show();
				break;
			default:
				$('#group_tools_group_invite_users').hide();
				$('#group_tools_group_invite_email').hide();
				$('#group_tools_group_invite_csv').hide();
				
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