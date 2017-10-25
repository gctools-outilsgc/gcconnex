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

$form_data = "";

$member_count = count($members);

$members = array_slice($members, 0, 3);

$textbox = elgg_view('input/text', array('id'=> 'txtSaveChk'));

foreach ($members as $member) {
	$checkbox = elgg_view('input/checkbox', array(
		'name' => 	'chkMember',
		'value' => 	$member->getGUID(),
		'label' =>	'labelling'));
	$member_icon = "<img class='img-circle' src='{$member->getIconURL(array('size' => 'small'))}'/>";
	$display_members .= "<div style='border-bottom:1px solid black; padding:5px 2px 2px 2px;'> {$checkbox} {$member_icon} {$member->getGUID()} / {$member->name}</div>";
}

$form_data .= " {$textbox}";
$pagination = "<a id='myLink' href='#' data-key='{\"group_guid\":\"".$group->getGUID()."\", \"page_selected\":\"2\"}'>see page</a>";

$form_data .= "<section>";
$form_data .= "<label>Currently displaying {$member_count} group members</label> ";

$form_data .= "
<br/>
<div style='border:1px gray solid;'>
	<div id='display-group-members' style='overflow-y:scroll; height:400px;'>

		{$display_members}

	</div>
	{$pagination}
</div>
<br/>

</section>
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

$(document).on('click', 'input[name="chkMember"]',function() {
	    var checkbox = $('input[name="chkMember"]');

    $('#txtSaveChk').val(checkbox.val());
});

var checkboxes = $('input[name="chkMember"]');

checkboxes.on("click", function () {
//console.log(">>>> checked!!!");
    // var $checked = checkboxes.filter(":checked"),
    //     checkedValues = $checked.map(function () {
    //         return this.value;
    //     }).get();
    // $('#txtSaveChk').val(checkedValues);
});



$('#myLink').click(function() {

	console.log("hey there");
	var me = $(this),
		data = me.data('key');

		console.log(data);

		elgg.action('wet4/group_tools/retrieve_group_members', {
			data: {
				'group_guid':data.group_guid,
				'page_selected':data.page_selected,
			},
			success: function(members) {

				for (var item in members.output.display_members){
					console.log(">>>> " + members.output.display_members[item]);
					$('#display-group-members').append("<div>"+members.output.display_members[item]+"</div>");
				}

				console.log("yay!" + JSON.stringify(members));
			}
		});


});


</script>


<?php


