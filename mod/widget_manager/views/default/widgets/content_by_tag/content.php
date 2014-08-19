<?php 

	global $CONFIG;

	$widget = $vars["entity"];
	
	// get widget settings
	$count = sanitise_int($widget->content_count, false);
	if(empty($count)){
		$count = 8;
	}
	
	$content_type = sanitise_string($widget->content_type);
	if(empty($content_type)){
		// set default content type filter
		if(elgg_is_active_plugin("blog")){
			$content_type = "blog";
		} elseif(elgg_is_active_plugin("file")){
			$content_type = "file";
		} elseif(elgg_is_active_plugin("pages")){
			$content_type = "page";
		}
	}
	
	if($content_type == "page"){
		// merge top and bottom pages
		$content_type = array("page_top", "page");
	} else {
		$content_type = array($content_type);
	}
	
	$tags_option = $widget->tags_option;
	if(!in_array($tags_option, array("and", "or"))){
		$tags_option = "and";
	}
	
	$wheres = array();
	$joins = array();
	
	// will always want to join these tables if pulling metastrings.
	$joins[] = "JOIN {$CONFIG->dbprefix}metadata n_table on e.guid = n_table.entity_guid";

	// get names wheres and joins
	$names_where = '';
	$values_where = '';
	
	$names = array("tags", "universal_categories");
	$values = string_to_tag_array($widget->tags);
	
	if(!empty($values)){
		$sanitised_names = array();
		foreach ($names as $name) {
			// normalise to 0.
			if (!$name) {
				$name = '0';
			}
			$sanitised_names[] = '\'' . sanitise_string($name) . '\'';
		}
	
		if ($names_str = implode(',', $sanitised_names)) {
			$joins[] = "JOIN {$CONFIG->dbprefix}metastrings msn on n_table.name_id = msn.id";
			$names_where = "(msn.string IN ($names_str))";
		}
		
		$sanitised_values = array();
		foreach ($values as $value) {
			// normalize to 0
			if (!$value) {
				$value = 0;
			}
			$sanitised_values[] = '\'' . sanitise_string($value) . '\'';
		}	
		
		$joins[] = "JOIN {$CONFIG->dbprefix}metastrings msv on n_table.value_id = msv.id";
		
		$values_where .= "(";
		foreach($sanitised_values as $i => $value){
			if($i !== 0){
				if($tags_option == "and"){
					// AND
					
					$joins[] = "JOIN {$CONFIG->dbprefix}metadata n_table{$i} on e.guid = n_table{$i}.entity_guid";
					$joins[] = "JOIN {$CONFIG->dbprefix}metastrings msn{$i} on n_table{$i}.name_id = msn{$i}.id";
					$joins[] = "JOIN {$CONFIG->dbprefix}metastrings msv{$i} on n_table{$i}.value_id = msv{$i}.id";
	 
					$values_where .= " AND (msn{$i}.string IN ($names_str) AND msv{$i}.string = $value)";
				} else {
					$values_where .= " OR (msv.string = $value)";
				}
			} else {
				$values_where .= "(msv.string = $value)";
			}				
		}
		$values_where .= ")";
	}
	
	$access = get_access_sql_suffix('n_table');
	
	if ($names_where && $values_where) {
		$wheres[] = "($names_where AND $values_where AND $access)";
	} elseif ($names_where) {
		$wheres[] = "($names_where AND $access)";
	} elseif ($values_where) {
		$wheres[] = "($values_where AND $access)";
	}
	
	// owner_guids
	if(!empty($widget->owner_guids)){
		$owner_guids = string_to_tag_array($widget->owner_guids);
		if(!empty($owner_guids)){
			foreach($owner_guids as $key => $guid){
				$owner_guids[$key] = sanitise_int($guid);
			}
		}
	}
		
	$options = array(
			"type" => "object",
			"subtypes" => $content_type,
			"limit" => $count,
			"full_view" => false,
			"pagination" => false,
			"joins" => $joins,
			"wheres" => $wheres,
			"owner_guids" => $owner_guids
		);
	
	if(($widget->context == "groups") && ($widget->group_only !== "no")){
		$options["container_guids"] = array($widget->container_guid);
	}
	
	elgg_push_context("search");
	
	$display_option = $widget->display_option;
	if(in_array($display_option, array("slim","simple"))){
		if($entities = elgg_get_entities($options)){		
			$num_highlighted = (int) $widget->highlight_first;
			$result .= "<ul class='elgg-list'>";
			
			foreach($entities as $index => $entity){
				$icon = "";
				$body = "";
				
				$result .= "<li class='elgg-item'>";
				
				if($display_option == "slim"){
					if($index < $num_highlighted){
						
						$icon = elgg_view_entity_icon($entity->getOwnerEntity(), "small");
						
						$text = elgg_view("output/url", array("href" => $entity->getURL(), "text" => $entity->title));
						$text .= "<br />";
						$text .= "<span title='" . date("r", $entity->time_created) . "'>" . substr(date("r", $entity->time_created),0,16) . "</span> - ";
						$description = elgg_get_excerpt($entity->description, 170);
						$text .= $description;
						if (elgg_substr($description, -3, 3) == '...') {
							$text .= " <a href=\"{$entity->getURL()}\">" . strtolower(elgg_echo('more')) . '</a>';
						}
						
						$result .= elgg_view_image_block($icon, $text);
					} else {
						$result .= "<div>";		
						$result .= "<span title='" . date("r", $entity->time_created) . "'>" . substr(date("r", $entity->time_created),0,16) . "</span> - <a href='" . $entity->getURL() . "'>" . $entity->title . "</a>";		
						$result .= "</div>";	
					}
				} else {
					$owner = $entity->getOwnerEntity();
					$icon = elgg_view_entity_icon($owner, "small");
					
					$text = elgg_view("output/url", array("href" => $entity->getURL(), "text" => $entity->title));
					$text .= "<br />";
					$text .= "<a href='" . $owner->getURL() . "'>" . $owner->name . "</a> ";
					$text .= "<span class='elgg-quiet'>" . elgg_view_friendly_time($entity->time_created) . "</span>";
					$result .= elgg_view_image_block($icon, $text);
				}
				
				$result .= "</li>";
			}
			
			$result .= "</ul>";
		}
	} else {
		$result = elgg_list_entities($options);
	}
	
	if(empty($result)){
		$result = elgg_echo("notfound");
	}
	echo $result;
	
	elgg_pop_context();
	