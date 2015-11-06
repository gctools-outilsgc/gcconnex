<?php

$entity = elgg_extract("entity", $vars);
$full_view = elgg_extract("full_view", $vars, false);

// do we have a blog
if (!empty($entity) && elgg_instanceof($entity, "object", "blog")) {
	$href = elgg_extract("href", $vars, $entity->getURL());
	$plugin_settings = elgg_extract("plugin_settings", $vars, false);
	
	$class = array("blog_tools_blog_image");
	if (isset($vars["class"])) {
		$class[] = $vars["class"];
	}
	
	$image_params = array(
		"alt" => $entity->title,
		"class" => elgg_extract("img_class", $vars, "")
	);
	
	// does the blog have an image
	if ($entity->icontime) {
		// which view
		if (empty($plugin_settings)) {
			// default image behaviour
			$image_params["src"] = $entity->getIconURL(elgg_extract("size", $vars, "medium"));
		} elseif ($full_view) {
			// full view of a blog
			static $blog_tools_full_image_size;
			static $blog_tools_full_image_align;
			
			if (!isset($blog_tools_full_image_size)) {
				$blog_tools_full_image_size = "large";
				
				$setting = elgg_get_plugin_setting("full_size", "blog_tools");
				if (!empty($setting)) {
					$blog_tools_full_image_size = $setting;
				}
			}
			
			if (!isset($blog_tools_full_image_align)) {
				$blog_tools_full_image_align = "right";
				
				$setting = elgg_get_plugin_setting("full_align", "blog_tools");
				if (!empty($setting)) {
					$blog_tools_full_image_align = $setting;
				}
			}
			
			if ($blog_tools_full_image_align != "none") {
				$href = false;
				$image_params["src"] = $entity->getIconURL($blog_tools_full_image_size);
				
				$class[] = "blog-tools-blog-image-" . $blog_tools_full_image_size;
				
				if ($blog_tools_full_image_size != "master") {
					if ($blog_tools_full_image_align == "right") {
						$class[] = "float-alt";
					} else {
						$class[] = "float";
					}
				}
			} else {
				// no image
				return true;
			}
		} else {
			// listing view of a blog
			// full view of a blog
			static $blog_tools_lising_image_size;
			static $blog_tools_listing_image_align;
			
			if (!isset($blog_tools_lising_image_size)) {
				$blog_tools_lising_image_size = "small";
				
				$setting = elgg_get_plugin_setting("listing_size", "blog_tools");
				if (!empty($setting)) {
					$blog_tools_lising_image_size = $setting;
				}
			}
			
			if (!isset($blog_tools_listing_image_align)) {
				$blog_tools_listing_image_align = "right";
				
				$setting = elgg_get_plugin_setting("listing_align", "blog_tools");
				if (!empty($setting)) {
					$blog_tools_listing_image_align = $setting;
				}
			}
			
			if ($blog_tools_listing_image_align != "none") {
				$image_params["src"] = $entity->getIconURL($blog_tools_lising_image_size);
				
				$class[] = "blog-tools-blog-image-" . $blog_tools_lising_image_size;
				
				if ($blog_tools_listing_image_align == "right") {
					$class[] = "float-alt";
				} else {
					$class[] = "float";
				}
			} else {
				// no image
				return true;
			}
		}
	}
	
	$image = elgg_view("output/img", $image_params);
	
	echo "<div class='" . implode(" ", $class) . "'>";
	if (!empty($href)) {
		$params = array(
			"href" => $href,
			"text" => $image,
			"is_trusted" => true,
		);
		$class = elgg_extract("link_class", $vars, "");
		if ($class) {
			$params["class"] = $class;
		}
		
		echo elgg_view("output/url", $params);
	} else {
		echo $image;
	}
	
	echo "</div>";
}
