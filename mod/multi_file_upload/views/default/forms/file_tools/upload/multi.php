<?php
/**
 * Elgg file browser uploader
 *
 * @package ElggFile
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels
 * Author: GCTools Team
 */
$page_owner = elgg_get_page_owner_entity();
$container_guid = $page_owner->getGUID();
$site_url = elgg_get_site_url();

if (elgg_instanceof($page_owner, "group", null, "ElggGroup")) {
	$return_url = $site_url . "file/group/" . $page_owner->getGUID() . "/all";
} else {
	$return_url = $site_url . "file/owner/" . $page_owner->username;
}

// load JS
//elgg_load_js("jquery.uploadify");
//elgg_load_css("jquery.uploadify");

elgg_load_js("fileinput-fa");
elgg_load_css("bootstrap-fileinput-css");
elgg_load_css("custom-bootstrap-fileinput");

?>
<script type="text/javascript">
	var file_tools_uploadify_return_url = "<?php echo $return_url; ?>";
</script>



<fieldset>
	<div>




	</div>

	<?php if (file_tools_use_folder_structure()) { ?>
	<div>
		<label for="file_tools_file_parent_guid"><?php echo elgg_echo("file_tools:forms:edit:parent"); ?><br /></label>
		<?php
			echo elgg_view("input/folder_select", array("name" => "folder_guid", "value" => get_input('parent_guid'), "id" => "file_tools_file_parent_guid"));
		?>

	</div>
	<?php }?>

	<div>
		<label for="file_tools_file_access_id"><?php echo elgg_echo('access'); ?><br /></label>

			<?php echo elgg_view('input/access', array('name' => 'access_id_file', 'id' => 'file_tools_file_access_id')); ?>

	</div>
	    <label for="multi-file-upload" class="control-label">Select File</label>
    	<input id="multi-file-upload" name="upload[]" type="file" multiple class="file-loading">
    	<div id="errorBlock" class="help-block"></div>
	<div class="elgg-foot">
		<?php
			echo elgg_view('input/securitytoken');
			echo elgg_view("input/hidden", array("name" => "container_guid", "value" => $container_guid));
			echo elgg_view("input/hidden", array("name" => "PHPSESSID", "value" => session_id()));

			//echo elgg_view("input/submit", array("value" => elgg_echo("upload"), 'class' => 'btn btn-primary'));
		?>
	</div>
</fieldset>
