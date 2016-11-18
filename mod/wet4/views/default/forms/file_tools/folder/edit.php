<?php

$folder = elgg_extract("folder", $vars);
$page_owner = elgg_extract("page_owner_entity", $vars);

$form_data = "";
if (!empty($folder)) {
	$title = $folder->title;
	$title2 = $folder->title2;
	$desc = $folder->description;
	$desc2 = $folder->description2;
	
	if (!empty($folder->parent_guid)) {
		$parent = $folder->parent_guid;
	} else {
		$parent = 0;
	}

	$access_id = $folder->access_id;

	$form_data = elgg_view("input/hidden", array("name" => "guid", "value" => $folder->getGUID()));

	$submit_text = elgg_echo("update");
} else {
	$title = "";
	$desc = "";

	$parent = get_input("folder_guid", 0);

	if (!empty($parent) && ($parent_entity = get_entity($parent))) {
		$access_id = $parent_entity->access_id;
	} else {
		if ($page_owner instanceof ElggGroup) {
			$access_id = $page_owner->group_acl;
		} else {
			$access_id = ACCESS_DEFAULT;
		}
	}

	$submit_text = elgg_echo("save");
}

/*$french = elgg_view('input/button', array(
    'value' => elgg_echo('btn:translate:fr'),
    'id' => 'btnClickfr',
    'class' => 'btn btn-default en',
    'onclick' => 'showfr()',
));

$english = elgg_view('input/button', array(
    'value' => elgg_echo('btn:translate:en'),
    'id' => 'btnClicken',
    'class' => 'btn btn-default fr',
    'onclick' => 'showen()',
));*/

$btn_language =  '<ul class="nav nav-tabs nav-tabs-language nav-tabs-language_folder">
  <li id="btnen_folder"><a href="#" onclick="showen()">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr_folder"><a href="#" onclick="showfr()">'.elgg_echo('lang:french').'</a></li>
</ul>';

//$form_data .= '<div id="btnfr">'.$french.'</div><div id="btnen"> '.$english.'</div>';
$form_data .= $btn_language;

$form_data .= '<div class="tab-content tab-content-border">';

$form_data .= elgg_view("input/hidden", array("name" => "page_owner", "value" => $page_owner->getGUID()));

$form_data .= "<div class='en' id='entitle'>";
$form_data .= "<label for='title'>" . elgg_echo("title:en") . "</label>";
$form_data .= elgg_view("input/text", array("name" => "title", "id" => "title", "value" => $title));
$form_data .= "</div>";

$form_data .= "<div class='fr' id='frtitle'>";
$form_data .= "<label for='title2'>" . elgg_echo("title:fr") . "</label>";
$form_data .= elgg_view("input/text", array("name" => "title2", "id" => "title2", "value" => $title2));
$form_data .= "</div>";

$form_data .= "<div class='en' id='endesc'>";
$form_data .= "<label for='description'>" . elgg_echo("file_tools:forms:edit:description") . "</label>";
$form_data .= elgg_view("input/longtext", array("name" => "description", "id" => "description", "value" => $desc));
$form_data .= "</div>";

$form_data .= "<div class='fr' id='frdesc'>";
$form_data .= "<label for='description2'>" . elgg_echo("file_tools:forms:edit:description2") . "</label>";
$form_data .= elgg_view("input/longtext", array("name" => "description2", "id" => "description2", "value" => $desc2));
$form_data .= "</div>";

$form_data .= "<div>";
$form_data .= "<label for='file_tools_parent_guid'>" . elgg_echo("file_tools:forms:edit:parent") . "</label>";
$form_data .= "<br />";
if (!empty($folder)) {
$form_data .= elgg_view("input/folder_select_move", array("name" => "file_tools_parent_guid", "id" => "file_tools_parent_guid", "folder" => $folder, "value" => $parent, "container_guid" => $page_owner->getGUID(), 'type' => 'folder'));
} else {
    $form_data .= elgg_view("input/folder_select", array("name" => "file_tools_parent_guid", "id" => "file_tools_parent_guid", "folder" => $folder, "value" => $parent, "container_guid" => $page_owner->getGUID(), 'type' => 'folder'));
}
$form_data .= "</div>";

// set context to influence access
$context = elgg_get_context();
elgg_set_context("file_tools");

$form_data .= "<div>";
$form_data .= "<label for='access_id'>" . elgg_echo("access") . "</label>";
$form_data .= "<br />";
$form_data .= elgg_view("input/access", array("name" => "access_id", "id" => "access_id", "value" => $access_id));
$form_data .= "</div>";

// restore context
elgg_set_context($context);

if (!empty($folder)) {
	$form_data .= "<div id='file_tools_edit_form_access_extra'>";
	$form_data .= "<div>" . elgg_view("input/checkboxes", array("options" => array(elgg_echo("file_tools:forms:edit:change_children_access") => "yes"), "value" => "yes", "name" => "change_children_access")) . "</div>";
	$form_data .= "<div>" . elgg_view("input/checkboxes", array("options" => array(elgg_echo("file_tools:forms:edit:change_files_access") => "yes"), "name" => "change_files_access")) . "</div>";
	$form_data .= "</div>";
}

$form_data .= "<div class='elgg-foot'>";
$form_data .= elgg_view("input/submit", array("value" => $submit_text));
$form_data .= "</div></div>";

echo $form_data;

elgg_unregister_menu_item('title2', 'new_folder');

if(get_current_language() == 'fr'){
?><!-- Jquerry not working -->
    <script>
  var btnfr_folder = document.getElementById('btnfr_folder');
  btnfr_folder.classList.add("active");

  document.getElementById('frtitle').style.display = "block";
  document.getElementById('frdesc').style.display = "block";
  document.getElementById('entitle').style.display = "none";
  document.getElementById('endesc').style.display = "none";

    </script>
<?php
}else{
?>
    <script>

  var btnen_folder = document.getElementById('btnen_folder');
  btnen_folder.classList.add("active");

  document.getElementById('entitle').style.display = "block";
  document.getElementById('endesc').style.display = "block";
  document.getElementById('frtitle').style.display = "none";
  document.getElementById('frdesc').style.display = "none";

    </script>
<?php
}
?>
<script>

jQuery(function(){

  var selector = '.nav-tabs-language_folder li';

  $(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
  });
});

function showen() {

   document.getElementById('entitle').style.display = "block";
   document.getElementById('endesc').style.display = "block";
   document.getElementById('frtitle').style.display = "none";
   document.getElementById('frdesc').style.display = "none";
}
function showfr() {
	
   document.getElementById('frtitle').style.display = "block";
   document.getElementById('frdesc').style.display = "block";
   document.getElementById('entitle').style.display = "none";
   document.getElementById('endesc').style.display = "none";
}

</script>
<?php