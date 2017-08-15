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

if (empty($vars['name'])) {
	$vars['name'] = 'groups';
}
$name = $vars['name'];
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

$guids = (array) elgg_extract('values', $vars, []);

$handler = elgg_extract('handler', $vars, 'livesearch');
$handler = htmlspecialchars($handler, ENT_QUOTES, 'UTF-8');

$limit = (int) elgg_extract('limit', $vars, 0);

echo elgg_format_element('link', [
	'href' => elgg_get_simplecache_url('css/group_tools/GroupPicker.css'),
	'rel' => 'stylesheet',
], '');

?>
<div class="elgg-group-picker ui-front" data-limit="<?php echo $limit ?>" data-name="<?php echo $name ?>" data-handler="<?php echo $handler ?>">
	<input type="text" class="elgg-input-group-picker" size="30"/>
	<ul class="elgg-group-picker-list">
		<?php
		foreach ($guids as $guid) {
			$entity = get_entity($guid);
			if ($entity) {
				echo elgg_view('input/grouppicker/item', [
					'entity' => $entity,
					'input_name' => $vars['name'],
				]);
			}
		}
		?>
	</ul>
</div>
<script type="text/javascript">
	require(['elgg/GroupPicker'], function (GroupPicker) {
		GroupPicker.setup('.elgg-group-picker[data-name="<?php echo $name ?>"]');
	});
</script>
