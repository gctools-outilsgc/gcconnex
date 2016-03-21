<?php
/**
 * Group Picker.  Sends an array of group guids.
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['values'] Array of gruop guids for already selected groups or null
 * @uses $vars['limit'] Limit number of groups (default 0 = no limit)
 * @uses $vars['name'] Name of the returned data array (default "groups")
 * @uses $vars['handler'] Name of page handler used to power search (default "livesearch")
 *
 * Defaults to lazy load group lists in alphabetical order. User needs
 * to type two characters before seeing the group popup list.
 *
 * As groups are selected they move down to a "groups" box.
 * When this happens, a hidden input is created to return the GUID in the array with the form
 */

elgg_load_js('jquery.ui.autocomplete.html');

if (empty($vars['name'])) {
	$vars['name'] = 'groups';
}
$name = $vars['name'];
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

$guids = (array)elgg_extract('values', $vars, array());

$handler = elgg_extract('handler', $vars, 'livesearch');
$handler = htmlspecialchars($handler, ENT_QUOTES, 'UTF-8');

$limit = (int)elgg_extract('limit', $vars, 0);

?>
<div class="elgg-group-picker ui-front" data-limit="<?php echo $limit ?>" data-name="<?php echo $name ?>" data-handler="<?php echo $handler ?>">
	<input type="text" class="elgg-input-group-picker" size="30"/>
	<ul class="elgg-group-picker-list">
		<?php
		foreach ($guids as $guid) {
			$entity = get_entity($guid);
			if ($entity) {
				echo elgg_view('input/grouppicker/item', array(
					'entity' => $entity,
					'input_name' => $vars['name'],
				));
			}
		}
		?>
	</ul>
</div>
<script type="text/javascript">
	// make sure the jQueryUI Autocomplete lib is available in ajax loaded views
	if (typeof(filter) !== "function") {
		$.getScript(elgg.get_site_url() + "vendors/jquery/jquery.ui.autocomplete.html.js");
	}
	
	require(['elgg/GroupPicker'], function (GroupPicker) {
		GroupPicker.setup('.elgg-group-picker[data-name="<?php echo $name ?>"]');
	});
</script>
