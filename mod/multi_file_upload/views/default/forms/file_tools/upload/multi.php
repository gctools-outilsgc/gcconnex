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

elgg_require_js('multi_file_upload/fileinput');

if(elgg_get_plugin_setting("load_custom_bs", "multi_file_upload")){
    elgg_load_css("mod-bootstrap-css");
    elgg_load_js("mod-bootstrap-js");
}

//elgg_load_css("bootstrap");
elgg_load_css("bootstrap-fileinput-css");
elgg_load_css("custom-bootstrap-fileinput");



?>
<script type="text/javascript">
	var file_tools_uploadify_return_url = "<?php echo $return_url; ?>";
</script>


<fieldset>

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

  <div>
	    <label for="multi-files-upload" class="control-label">Select File</label>
    	<input id="multi-files-upload" name="upload[]" type="file" multiple class="file-loading">
    	<div id="errorBlock" class="help-block"></div>
  </div>

	<div class="elgg-foot">
		<?php
			echo elgg_view('input/securitytoken');
			echo elgg_view("input/hidden", array("name" => "container_guid", "value" => $container_guid));
			echo elgg_view("input/hidden", array("name" => "PHPSESSID", "value" => session_id()));

		?>
	</div>
</fieldset>
