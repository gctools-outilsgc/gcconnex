<?php
/**
* Profile Manager
*
* Replaces default Elgg profile edit form
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*
* @uses $vars['entity'] The user entity
* @uses $vars['profile'] Profile items from get_config('profile_fields'), defined in profile/start.php for now
*/

// id profile_edit_form
?>
<div>
	<label><?php echo elgg_echo('user:name:label'); ?></label>
	<div><?php echo $vars['entity']->name; ?></div>
</div>
<?php

// Build fields

$categorized_fields = profile_manager_get_categorized_fields($vars['entity'], true);
$cats = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

$edit_profile_mode = elgg_get_plugin_setting("edit_profile_mode", "profile_manager");
$simple_access_control = elgg_get_plugin_setting("simple_access_control","profile_manager");

if (!empty($cats)) {
	
	// Profile type selector
	$setting = elgg_get_plugin_setting("profile_type_selection", "profile_manager");
	if (empty($setting)) {
		// default value
		$setting = "user";
	}
	
	// can user edit? or just admins
	if ($setting == "user" || elgg_is_admin_logged_in()) {
		// get profile types
		
		$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			"limit" => false,
			"owner_guid" => elgg_get_site_entity()->getGUID()
		);
		$types = elgg_get_entities($options);
		if ($types) {
			$types_description = "";
			
			$dropdown_options = array();
			$dropdown_options[""] = elgg_echo("profile_manager:profile:edit:custom_profile_type:default");
			
			foreach ($types as $type) {
				
				$dropdown_options[$type->getGUID()] = $type->getTitle();
				
				// preparing descriptions of profile types
				$description = $type->getDescription();
				
				if (!empty($description)) {
					$types_description = "<div id='custom_profile_type_description_" . $type->getGUID() . "' class='custom_profile_type_description'>";
					$types_description .= "<h3 class='settings'>" . elgg_echo("profile_manager:profile:edit:custom_profile_type:description") . "</h3>";
					$types_description .= $description;
					$types_description .= "</div>";
				}
			}
			
			?>
			<script type="text/javascript">
				$(document).ready(function(){
					elgg.profile_manager.change_profile_type();
				});
			</script>
			<?php

			echo "<div>";
			echo "<label>" . elgg_echo("profile_manager:profile:edit:custom_profile_type:label") . "</label>";
			echo elgg_view("input/dropdown", array("name" => "custom_profile_type",
													"id" => "custom_profile_type",
													"options_values" => $dropdown_options,
													"onchange" => "elgg.profile_manager.change_profile_type();",
													"value" => $vars['entity']->custom_profile_type));
			echo elgg_view('input/hidden', array('name' => 'accesslevel[custom_profile_type]', 'value' => ACCESS_PUBLIC));
			echo "</div>";
			
			echo $types_description;
		}
	} else {
		$profile_type = $vars['entity']->custom_profile_type;
		
		if (!empty($profile_type)) {
			echo elgg_view("input/hidden", array("name" => "custom_profile_type", "value" => $profile_type));
			echo elgg_view("input/hidden", array("name" => "accesslevel[custom_profile_type]", "value" => ACCESS_PUBLIC));
			?>
			<script type="text/javascript">
				$(document).ready(function(){
					$('.custom_profile_type_<?php echo $profile_type; ?>').show();
				});
			</script>
			<?php
		}
	}
	
	$tabs = array();
	$tab_content = "";
	$list_content = "";
	
	foreach ($cats as $cat_guid => $cat) {
		// make nice title for category
		if (empty($cat_guid) || !($cat instanceof ProfileManagerCustomFieldCategory)) {
			$cat_title = elgg_echo("profile_manager:categories:list:default");
		} else {
			$cat_title = $cat->getTitle();
		}
	
		$class = "";
		if (!empty($cat_guid) && ($cat instanceof ProfileManagerCustomFieldCategory)) {
			
			$profile_type_options = array(
					"type" => "object",
					"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
					"limit" => false,
					"owner_guid" => $cat->getOwnerGUID(),
					"site_guid" => $cat->site_guid,
					"relationship" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
					"relationship_guid" => $cat_guid,
					"inverse_relationship" => true
				);
			
			if ($profile_types = elgg_get_entities_from_relationship($profile_type_options)) {
				
				$class = "custom_fields_edit_profile_category";
				
				// add extra class so it can be toggle in the display
				foreach ($profile_types as $type) {
					$class .= " custom_profile_type_" . $type->getGUID();
				}
			}
		}
				
		$tab_content .= "<div id='profile_manager_profile_edit_tab_content_" . $cat_guid . "' class='profile_manager_profile_edit_tab_content'>\n";
			
		$list_content .= "<div id='" . $cat_guid . "' class='" . $class . "'>";
		if (count($cats) > 1) {
			$list_content .= "<h3 class='settings'>" . $cat_title . "</h3>";
		}
		$list_content .= "<fieldset>";
		
		// display each field for currect category
		$hide_non_editables = elgg_get_plugin_setting("hide_non_editables", "profile_manager");
		
		$visible_fields = 0;
		
		foreach ($fields[$cat_guid] as $field) {
			$metadata_name = $field->metadata_name;
			
			// get options
			$options = $field->getOptions();
			
			// get type of field
			if ($field->user_editable == "no") {
				$valtype = "non_editable";
			} else {
				$valtype = $field->metadata_type;
			}
			// make title
			$title = $field->getTitle();
							
			// get value
			$metadata = elgg_get_metadata(array(
				'guid' => $vars['entity']->guid,
				'metadata_name' => $metadata_name,
				'limit' => false
			));
			
			if ($metadata) {
				$metadata = $metadata[0];
				
				$value = $vars['entity']->$metadata_name;
				$access_id = $metadata->access_id;
			} else {
				$value = '';
				$access_id = get_default_access($vars["entity"]);
			}

			if ($hide_non_editables == "yes" && ($valtype == "non_editable")) {
				$field_result = "<div class='hidden_non_editable'>";
			} else {
				$visible_fields++;
				$field_result = "<div>";
			}
			
			$field_result .= "<label>" . $title . "</label>";
			
			if ($hint = $field->getHint()) {
				$field_result .= "<span class='custom_fields_more_info' id='more_info_" . $metadata_name . "'></span>";
				$field_result .= "<span class='custom_fields_more_info_text' id='text_more_info_" . $metadata_name . "'>" . $hint . "</span>";
			}
			
			if ($valtype == "dropdown") {
				// add div around dropdown to let it act as a block level element
				$field_result .= "<div>";
			}
			
			$field_result .= elgg_view("input/" . $valtype, array(
															'name' => $metadata_name,
															'value' => $value,
															'options' => $options
															));
			
			if ($valtype == "dropdown") {
				$field_result .= "</div>";
			}
			
			$field_result .= elgg_view('input/access', array('name' => 'accesslevel[' . $metadata_name . ']', 'value' => $access_id));
			$field_result .= "</div>";
			
			$tab_content .= $field_result;
			$list_content .= $field_result;
		}
		
		if ($visible_fields) {
			// only add tab if there are visible fields
			$tabs[] = array(
					'title' => $cat_title,
					'url' => "#" . $cat_guid,
					'id' => $cat_guid,
					'class' => $class
			);
		}
		
		$tab_content .= "</div>\n";
		
		$list_content .= "</fieldset>";
		$list_content .= "</div>\n";
	}
	
	if (($edit_profile_mode == "tabbed") && (count($cats) > 1)) {
		?>
		<div id="profile_manager_profile_edit_tabs">
			<?php echo elgg_view('navigation/tabs', array('tabs' => $tabs)); ?>
		</div>
		<div id="profile_manager_profile_edit_tab_content_wrapper">
			<?php echo $tab_content; ?>
		</div>
		<?php
	} else {
		echo $list_content;
	}
}

if ($simple_access_control == "yes") {
	?>
	<div>
		<label><?php echo elgg_echo("profile_manager:simple_access_control"); ?></label>
		<?php echo elgg_view('input/access',array('name' => 'simple_access_control', 'value' => $access_id, 'class' => 'simple_access_control', 'js' => 'onchange="set_access_control(this.value)"')); ?>
	</div>
	<?php
}
?>

<div class="elgg-foot">
<?php
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid));
	echo elgg_view('input/submit', array('value' => elgg_echo('save')));
?>
</div>

<?php
if ($simple_access_control == "yes") {
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".simple_access_control").val($(".elgg-input-access:first").val()).trigger("change");
		});
	
		function set_access_control(val){
			$(".elgg-input-access").not(".simple_access_control").val(val);
		}
	</script>
	<style type="text/css">
		.elgg-input-access {
			display: none;
		}
		.simple_access_control {
			display: inline-block;
		}
	</style>
	<?php
}
