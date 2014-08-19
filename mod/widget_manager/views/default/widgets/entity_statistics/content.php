<?php
// Get entity statistics
$entity_stats = get_entity_statistics();
$selected_entities = $vars["entity"]->selected_entities;

?>
<table class='elgg-table'>
	<?php
		foreach ($entity_stats as $k => $entry) {
			arsort($entry);
			foreach ($entry as $a => $b) {
				$key = $k . "|" . $a;
				if(empty($selected_entities) || in_array($key, $selected_entities)){
					
					if ($a == "__base__") {
						$a = elgg_echo("item:{$k}");
						if($k == "user"){
							$b .= " (" . count(find_active_users(600,9999)) . " " .  elgg_echo("online") . ")";
						}
					} else {
						if (empty($a)) {
							$a = elgg_echo("item:{$k}");
						} else {
							$a = elgg_echo("item:{$k}:{$a}");
						}

						if (empty($a)) {
							$a = "$k $a";
						}
					}
					echo "<tr><td>{$a}:</td><td>{$b}</td></tr>";
				}
			}
		}
	?>
</table>
