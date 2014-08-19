<?php

	if(!empty($vars["entity"])){
		
		$tabs = array(
			"edit" => array(
				"text" => elgg_echo("group_tools:group:edit:profile"),
				"href" => "#profile",
				"link_class" => "group-tools-group-edit-profile",
				"priority" => 200,
				"selected" => true
			),
			"other" => array(
				"text" => elgg_echo("group_tools:group:edit:other"),
				"href" => "#other",
				"link_class" => "group-tools-group-edit-other",
				"priority" => 300
			)
		);
		
		foreach($tabs as $name => $tab){
			$tab["name"] = $name;
			
			elgg_register_menu_item("filter", $tab);
		}
		
		echo "<div id='group_tools_group_edit_tabbed'>";
		echo elgg_view_menu("filter", array("sort_by" => "priority", "class" => "elgg-menu-hz"));
		echo "</div>";
	} 