<?php

$widget = $vars["entity"];
if (empty($widget)) {
	$guid = get_input("guid");
	if ($guid) {
		$widget = get_entity($guid);
		if (!($widget instanceof ElggWidget)) {
			return;
		}		
	}
}

$q = get_input("q");
$q = sanitise_string($q);

$form_body = elgg_view("input/text", array("name" => "q", "title" => elgg_echo("search"), "value" => $q));
echo elgg_view("input/form", array("body" => $form_body, "class" => "widget-user-search-form"));

$result = array();

if (!empty($q)) {
	$dbprefix = elgg_get_config("dbprefix");
	$hidden = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	
	$options = array(
		"type" => "user",
		"relationship" => "member_of_site",
		"relationship_guid" => elgg_get_site_entity()->getGUID(),
		"inverse_relationship" => true,
		"joins" => array("JOIN " . $dbprefix . "users_entity ue ON e.guid = ue.guid"),
		"wheres" => array("((ue.username LIKE '%" . $q . "%') OR (ue.email LIKE '%" . $q . "%') OR (ue.name LIKE '%" . $q . "%'))")
	);
	
	if ($entities = elgg_get_entities_from_relationship($options)) {
		foreach ($entities as $entity) {
			$entity_data = array();
			
			$entity_data[] = elgg_view("output/url", array("text" => $entity->name, "href" => $entity->getURL()));
			
			$entity_data[] = $entity->username;
			$entity_data[] = $entity->email;
			
			if (elgg_get_user_validation_status($entity->getGUID()) !== false) {
				$entity_data[] = elgg_echo("option:yes");
			} else {
				$entity_data[] = elgg_echo("option:no");
			}
			
			$entity_data[] = elgg_echo("option:" . $entity->enabled);
							
			$entity_data[] = htmlspecialchars(date(elgg_echo('friendlytime:date_format'), $entity->time_created));
			
			$result[] = "<td>" . implode("</td><td>", $entity_data) . "</td>";
		}
	}

	access_show_hidden_entities($hidden);
}

if (empty($result)) {
	echo elgg_echo("notfound");
} else {
	echo "<table class='elgg-table mtm'><tr>";
	echo "<th>" . elgg_echo("name") . "</th>";
	echo "<th>" . elgg_echo("username") . "</th>";
	echo "<th>" . elgg_echo("email") . "</th>";
	echo "<th>" . elgg_echo("validated") . "</th>";
	echo "<th>" . elgg_echo("enabled") . "</th>";
	echo "<th>" . elgg_echo("time_created") . "</th>";
	echo "</tr><tr>";
	echo implode("</tr><tr>", $result);
	echo "</tr></table>";
}

?>
<script type='text/javascript'>
	$(document).ready(function(){
		$(".widget-user-search-form").submit(function(){
			var new_val = $(this).find("[name='q']").val();
			
			$("#elgg-widget-content-<?php echo $widget->getGUID(); ?>").load(elgg.normalize_url("ajax/view/widgets/user_search/content?guid=<?php echo $widget->getGUID(); ?>&q=" + new_val));
			return false;
		});
	});
</script>