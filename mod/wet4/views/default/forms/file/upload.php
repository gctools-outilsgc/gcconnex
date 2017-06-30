<?php
/**
 * Elgg file upload/save form
 *
 * @package ElggFile
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels + content translation support
 * Author: GCTools Team
 */
// once elgg_view stops throwing all sorts of junk into $vars, we can use
$title = elgg_extract('title', $vars, '');
$title2 = elgg_extract('title2', $vars, '');
$desc = elgg_extract('description', $vars, '');
$desc2 = elgg_extract('description2', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);

// boolean, indicate whether this is an edit or not
$edit_file = false;

if (!$container_guid) {
	$container_guid = elgg_get_logged_in_user_guid();
}
$guid = elgg_extract('guid', $vars, null);

if ($guid) {
	$edit_file = true;
	$file_label = elgg_echo("file:replace");
	$submit_label = elgg_echo('save');
} else {
	$file_label = elgg_echo("file:file");
	$submit_label = elgg_echo('upload');
}

// decode json into English / French parts
$json_title = json_decode($title);
$json_desc = json_decode($desc);

if ( $json_title ){
  $title2 = $json_title->fr;
  $title = $json_title->en;
}

if ( $json_desc ){
  $desc2 = $json_desc->fr;
  $desc = $json_desc->en;
}


elgg_unregister_menu_item('title', 'new_folder');

$btn_language =  '<ul class="nav nav-tabs nav-tabs-language">
  <li id="btnen"><a href="#" id="btnClicken">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr"><a href="#" id="btnClickfr">'.elgg_echo('lang:french').'</a></li>
</ul>';

echo $btn_language;
?>
<div class="tab-content tab-content-border">
<div>
	<label for="upload"><?php echo $file_label; ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload', 'id' => 'upload', 'autofocus' =>'true', 'required '=> "required")); ?>
</div>
<div class="en">
	<label for="title"><?php echo elgg_echo('title:en'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'id' => 'title', 'value' => $title, 'required '=> "required")); ?>
</div>
<div class="fr">
	<label for="title2"><?php echo elgg_echo('title:fr'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title2', 'id' => 'title2', 'value' => $title2, 'required '=> "required")); ?>
</div>
<div class="en">
	<label for="description"><?php echo elgg_echo('file:description:en'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'id' => 'description', 'value' => $desc)); ?>
</div>
<div class="fr">
	<label for="description2"><?php echo elgg_echo('file:description:fr'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description2', 'id' => 'description2', 'value' => $desc2)); ?>
</div>
<div>
	<label for="tags"><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags', 'value' => $tags)); ?>
</div>

<?php
if (file_tools_use_folder_structure()) {
	$parent_guid = 0;
	if ($file = elgg_extract("entity", $vars)) {
		if ($folders = $file->getEntitiesFromRelationship(FILE_TOOLS_RELATIONSHIP, true, 1)) {
			$parent_guid = $folders[0]->getGUID();
		}
	}
	?>
	<div>
		<label for="folder_guid"><?php echo elgg_echo("file_tools:forms:edit:parent"); ?><br />
		<?php
			echo elgg_view("input/folder_select", array("name" => "folder_guid", "id" => "folder_guid", "value" => $parent_guid));
		?>
		</label>
	</div>
<?php
}

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label for="access_id"><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'id' => 'access_id', 'value' => $access_id, 'entity' => get_entity($guid),)); ?>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'file_guid', 'value' => $guid));
    elgg_unregister_menu_item('title2', 'new_folder');
}

echo elgg_view('input/submit', array('value' => $submit_label, 'class' => 'btn btn-primary mrgn-tp-md'));


/// minor edit functionality (TODO: possibly extend view in the future, for all minor edits)
if ($edit_file) {
	echo "<h2>".elgg_echo('cp_notify:minor_edit_header')."</h2>";
	echo elgg_view('input/checkbox', array(
		'name' 		=>	"minor_edit",
		'value' 	=>	1,
		'default' 	=> 	0,
		'label' 	=>	elgg_echo('page:minor_edit_label'),
		'checked' 	=>	false,
		'id' 		=>	'minor_edit',
		'class' 	=>	'chkboxClass',
	));
}


echo'</div></div>';


if(get_current_language() == 'fr'){
?>
	<script>
		jQuery('.fr').show();
	    jQuery('.en').hide();
	    jQuery('#btnfr').addClass('active');

	</script>
<?php
}else{
?>
	<script>
		jQuery('.en').show();
    	jQuery('.fr').hide();
    	jQuery('#btnen').addClass('active');
	</script>
<?php
}
?>
<script>
jQuery(function(){

	var selector = '.nav-tabs-language li';

	$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

		jQuery('#btnClickfr').click(function(){
               jQuery('.fr').show();
               jQuery('.en').hide();
        });

          jQuery('#btnClicken').click(function(){
               jQuery('.en').show();
               jQuery('.fr').hide();
        });
});

<?php if(elgg_in_context('embed')){ ?>
  var validExtentions = get_file_tools_settings('single');
  var newExt = validExtentions.replace(/, /g, '|'); //format the extensions for validation

  //do form validation here for ajax view
  $(".elgg-form").each(function(){
    $(this).validate({
      rules: {
        upload: {
          extension: newExt
        },
      },
      messages: {  //add custom message for file validation
          upload:{
              extension:elgg.echo('form:invalid:extensions',[validExtentions])
          }
      },
      submitHandler: function(form) {
        $(form).find('button').prop('disabled', true);
        form.ajaxSubmit();
      },
    });
  });
  <?php } ?>

  <?php if($guid){ ?>
    //remove required on file input if editing file
    $('#upload').removeAttr('required');
  <?php } ?>
</script>
