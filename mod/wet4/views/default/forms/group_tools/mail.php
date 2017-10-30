<?php
/**
 * Mail group members
 * GC_MODIFICATION
 * Description: Added accessible labels + fixed url
 * Author: GCTools Team
 * Modified: Christine Yu
 */


$group = $vars["entity"];
$members = $vars["members"];

// CYu: https://elgg.org/discussion/view/2551792/kill-the-friendspicker
// CYu: Friendspicker input form creates heavy performance load (either server or client side)
// TODO: make sure that cp_notification is also turned on
$query = "SELECT ue.name, r.guid_one FROM elggentity_relationships r, elggusers_entity ue WHERE r.guid_one = ue.guid AND r.relationship = 'member' AND r.guid_two = {$group->getGUID()}";
$members = get_data($query);

$form_data = "";

$number_of_members_per_page = 10;

$member_count = count($members);
$members = array_slice($members, 0, $number_of_members_per_page);

$number_of_pages = floor($member_count / $number_of_members_per_page);

/// pagination
$pagination = "<ul class='elgg-pagination pagination'>";
for ($x = 0; $x <= $number_of_pages; $x++) {
	$page_number = $x + 1;
	$pagination .= "<li> <a class='myLink' data-key='{
											\"group_guid\":\"{$group->getGUID()}\",
											\"page_selected\":\"{$x}\",
											\"number_of_members_per_page\":\"{$number_of_members_per_page}\"
											}'>{$page_number}</a> </li>";
}
$pagination .= "</ul>";


$textbox = elgg_view('input/hidden', array('id'=> 'txtSaveChk', 'name' => 'txtSaveChk', 'value' => ''));

foreach ($members as $member) {
	$member = get_entity($member->guid_one);
	$member_icon = "<img class='img-circle' src='{$member->getIconURL(array('size' => 'small'))}'/>";
	$checkbox = elgg_view('input/checkbox', array(
		'name' => 	'chkMember',
		'value' => 	$member->getGUID(),
	));
	if (elgg_is_admin_logged_in()) {
		$show_user_id = "( {$member->getGUID()} )";
	}
	$display_members .= "<div style='border-bottom:1px solid #ddd; padding:5px 2px 2px 2px;'> {$checkbox} {$member_icon} {$member->name} {$show_user_id} </div>";
}

$chkMailAll = elgg_view('input/checkbox', array(
	'name' => 	'chkMailToAll',
	'value' => 	'1',
	'label' => 'Mail to all members',
));

$form_data .= " {$textbox}";


$form_data .= "

<div style='width:100%;'> 
	<div>
		<label class='btn btn-primary active'> {$chkMailAll} </label>
	</div>
	<section id='section-mail-members'>
		<label>Currently displaying {$member_count} group members</label> 
		<div style='border-top:2px solid #ddd; border-bottom:2px solid #ddd; border-left:2px solid #ddd'>
			<div id='display-group-members' style='overflow-y:scroll; height:400px;'>
				{$display_members}
			</div>
		</div>
		{$pagination}
	</section>
</div>
<br/>

";


$form_data .= "<div>";
$form_data .= "<label for='title'>" . elgg_echo("group_tools:mail:form:title") . "</label>";
$form_data .= elgg_view("input/text", array("name" => "title", "id" => "title", 'required '=> "required"));
$form_data .= "</div>";

$form_data .= "<div>";
$form_data .= "<label for='description'>" . elgg_echo("group_tools:mail:form:description") . "</label>";
$form_data .= elgg_view("input/longtext", array("name" => "description", "id" => "description", 'required '=> "required", "class" => 'validate-me'));
$form_data .= "</div>";

$form_data .= "<div class='elgg-foot'>";
$form_data .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
$form_data .= elgg_view("input/submit", array("value" => elgg_echo("send")));
$form_data .= "</div>";

echo $form_data;



?>

<script>

/// keeps track of the selected group members for group mailing
$(document).on('click', 'input[name="chkMember"]',function() {
	var checkbox = $(this);
	var txtSaveChk = $('#txtSaveChk');

	if (checkbox.is(":checked")) {
		var txtSaveChkVal = txtSaveChk.val();
		if (txtSaveChkVal == '') {
			$('#txtSaveChk').val(checkbox.val());
		} else {
			$('#txtSaveChk').val(txtSaveChkVal + ',' + checkbox.val());
		}
	} else {
		var txtSaveChkValArr = txtSaveChk.val().split(',');
		var index = txtSaveChkValArr.indexOf(checkbox.val());
		txtSaveChkValArr.splice(index, 1);
		$('#txtSaveChk').val(txtSaveChkValArr.join());
		
	}
});


$(document).on('click', 'input[name="chkMailToAll"]',function() {
	var checkbox = $(this);			

	if (checkbox.attr('checked')) {
		$('#section-mail-members').hide();
	} else {
		$('#section-mail-members').show();
	}
});



$('.myLink').click(function() {
	var me = $(this),
	data = me.data('key');
	elgg.action('wet4/group_tools/retrieve_group_members', {
		data: {
			'group_guid':data.group_guid,
			'page_selected':data.page_selected,
			'number_of_members_per_page':data.number_of_members_per_page,
			'save_selected':$('#txtSaveChk').val()
		},
		success: function(members) {
			$('#display-group-members').empty();

			for (var item in members.output.display_members){
				$('#display-group-members').append("<div>"+members.output.display_members[item]+"</div>");
			}
		}
	});
});


</script>


<?php


