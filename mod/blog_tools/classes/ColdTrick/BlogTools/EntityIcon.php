<?php

namespace ColdTrick\BlogTools;

/**
 * Router handling
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class EntityIcon {
	
	/**
	 * Return the url for a blog icon (if any)
	 *
	 * @param string $hook        "entity:icon:url"
	 * @param string $entity_type "object"
	 * @param string $returnvalue the current icon url
	 * @param array  $params      supplied params
	 *
	 * @return string|void
	 */
	public static function blogIcon($hook, $entity_type, $returnvalue, $params) {
		
		if (empty($params) || !is_array($params)) {
			return $returnvalue;
		}
		
		$entity = elgg_extract("entity", $params);
		if (empty($entity) || !elgg_instanceof($entity, "object", "blog")) {
			return $returnvalue;
		}
		
		$iconsizes = (array) elgg_get_config("icon_sizes");
		$size = strtolower(elgg_extract("size", $params));
		if (!array_key_exists($size, $iconsizes)) {
			$size = "medium";
		}
			
		$icontime = (int) $entity->icontime;
		if (!$icontime) {
			return $returnvalue;
		}
		
		$url = elgg_http_add_url_query_elements("mod/blog_tools/pages/thumbnail.php", array(
			"guid" => $entity->getOwnerGUID(),
			"blog_guid" => $entity->getGUID(),
			"size" => $size,
			"icontime" => $icontime
		));
		
		return elgg_normalize_url($url);
	}
}