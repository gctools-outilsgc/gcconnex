<?php

/**
 * Elgg autosubscribegroup plugin
 * This plugin allows new users to get joined to groups automatically when they register.
 *
 * @package autosubscribegroups
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author RONNEL Jérémy
 * @copyright (c) Elbee 2008
 * @link /www.notredeco.com
 *
 * for Elgg 1.8 onwards by iionly (iionly@gmx.de)
 */

function limit_text($text, $limit = 30) {
	if (str_word_count($text, 0) > $limit) {
		$words = str_word_count($text, 2);
		$pos = array_keys($words);
		$text = substr($text, 0, $pos[$limit]) . '...';
	}
	return $text;
}

elgg_load_js('lightbox');
elgg_load_css('lightbox');

?>

<style type="text/css">
	table.group-table		{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; margin: 10px 0; }
	table.group-table th 	{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	table.group-table td 	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	.align-center			{ text-align: center; }
	.elgg-form-settings		{ max-width: none; }
	.organization-list		{ list-style-type: circle; margin-left: 1.5em; }
	.add-organization		{ text-align: center; display: block; margin-top: 10px; }
	.delete-organization	{ font-weight: bold; color: red; cursor: pointer; }
</style>

<script type="text/javascript">
	$(function() {
		var autoGroups = $("#autoGroupList").val();
		var autoGroupsArray = [];
		if(autoGroups !== ""){ autoGroupsArray = autoGroups.split(','); }

		$(".auto-subscribe").change(function(e){
			var id = $(this).val();
			autoGroupsArray = jQuery.grep(autoGroupsArray, function(value) { return value != id; });
			if(this.checked){ autoGroupsArray.push(id); }
		    $("#autoGroupList").val(autoGroupsArray.join(","));
		});

		var adminGroups = $("#adminGroupList").val();
		var adminGroupsArray = [];
		if(adminGroups !== ""){ adminGroupsArray = adminGroups.split(','); }

		$(".admin-subscribe").change(function(e){
			var id = $(this).val();
			adminGroupsArray = jQuery.grep(adminGroupsArray, function(value) { return value != id; });
			if(this.checked){ adminGroupsArray.push(id); }
		    $("#autoGroupList").val(adminGroupsArray.join(","));
		});

		$(".group-table").on('click', '.delete-organization', function(e){
			e.preventDefault();
			var group_id = $(this).data('group');
			var user_type = $(this).data('user-type');
			var institution = $(this).data('institution');
			var organization = $(this).data('organization');

			var organizationGroupsArray = JSON.parse($("#organizationGroupList").val());
			$(organizationGroupsArray[group_id]).each(function(index, value) {
				if(Object.keys(value)[0] == user_type){
					var next = value[Object.keys(value)[0]];

					if(next == organization){
						organizationGroupsArray[group_id].splice(index, 1);
					} else if(Object.keys(next)[0] == institution){
						if(next[Object.keys(next)[0]] == organization){
							organizationGroupsArray[group_id].splice(index, 1);
						}
					}
				}
				if(organizationGroupsArray[group_id].length === 0){
					delete organizationGroupsArray[group_id];
				}
			});

			$("#organizationGroupList").val(JSON.stringify(organizationGroupsArray));
			$(this).closest('li').remove();
		});
	});
</script>

<?php

$autoGroups = explode(',', $vars['entity']->autogroups);
$adminGroups = explode(',', $vars['entity']->admingroups);
$organizationGroups = json_decode($vars['entity']->organizationgroups, true);
$groups = elgg_get_entities(array(
	'types' => 'group',
	'limit' => 0,
));
sort($groups);

echo '<table class="group-table"><thead><tr>
	<th width="5%">ID</th>
	<th width="25%">' . elgg_echo('autosubscribe:name') . '</th>
	<th width="30%">Description</th>
	<th width="5%">' . elgg_echo('autosubscribe:autogroups') . '</th>
	<th width="5%">' . elgg_echo('autosubscribe:admingroups') . '</th>
	<th width="30%">' . elgg_echo('autosubscribe:organizationgroups') . '</th>
	</tr></thead><tbody>';
foreach($groups as $group){
	$autoChecked = (in_array($group->guid, $autoGroups)) ? " checked": "";
	$adminChecked = (in_array($group->guid, $adminGroups)) ? " checked": "";
	if($group->enabled == "yes"){
		echo '<tr>';
		echo '<td>' . $group->guid . '</td>';
		echo '<td><a href="' . elgg_get_site_url() . 'groups/profile/' . $group->guid . '/' . elgg_get_friendly_title($group->name) . '" target="_blank">' . $group->name . '</a></td>';
		echo '<td>' . limit_text(strip_tags($group->description)) . '</td>';
		echo '<td class="align-center"><input class="auto-subscribe" type="checkbox" value="' . $group->guid . '"' . $autoChecked . ' /></td>';
		echo '<td class="align-center"><input class="admin-subscribe" type="checkbox" value="' . $group->guid . '"' . $adminChecked . ' /></td>';
		echo '<td data-group="' . $group->guid . '"><ul class="organization-list">';
		foreach($organizationGroups[$group->guid] as $value){
			$user_type = $institution = $organization = "";
			if(is_array($value)){
				$user_type = array_keys($value)[0];
				$organization = array_values($value)[0];
			}
			if(is_array($organization)){
				$institution = $organization;
				$organization = array_values($institution)[0];
				$institution = array_keys($institution)[0];
			}
			$name = ucfirst($user_type);
			if(trim($institution) !== ""){ $name .= ', ' . ucfirst($institution); }
			if(trim($organization) !== ""){ $name .= ', ' . $organization; }
			echo '<li>' . $name . ' <a class="delete-organization" data-group="' . $group->guid . '" data-user-type="' . $user_type . '" data-institution="' . $institution . '" data-organization="' . $organization . '">X</a></li>';
		}
		echo '</ul>' . elgg_view('output/url', [
			'text' => 'Add Organization',
			'href' => 'ajax/view/organization_form/form?group_id=' . $group->guid,
			'class' => 'elgg-lightbox elgg-button elgg-button-action add-organization',
			'data-colorbox-opts' => json_encode([
				'width' => '600px',
				'height' => '400px',
			])
		]) . '</td>';
		echo '</tr>';
	}
}
echo '</tbody></table>';

echo elgg_view('input/text', array('type' => 'hidden', 'id' => 'autoGroupList', 'name' => 'params[autogroups]', 'value' => $vars['entity']->autogroups));
echo elgg_view('input/text', array('type' => 'hidden', 'id' => 'adminGroupList', 'name' => 'params[admingroups]', 'value' => $vars['entity']->admingroups));
echo elgg_view('input/text', array('type' => 'hidden', 'id' => 'organizationGroupList', 'name' => 'params[organizationgroups]', 'value' => $vars['entity']->organizationgroups));
