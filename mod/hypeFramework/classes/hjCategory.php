<?php

/**
 * Creates hjCategory class to manage categories
 */
class hjCategory extends hjObject {

	function __construct($guid = null) {
		parent::__construct($guid);
	}

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = 'hjcategory';
	}

	public function save() {
		$return = parent::save();

		if ($return) {
			$this->setAncestry();
			if (!isset($this->priority))
				$this->priority = 0;
		}

		return $return;
	}
	
	public function getMenuItem(ElggMenuItem $parent, $top_only = false) {
		if ($parent) {
			$menu_item = array(
				'name' => "{$parent->getName()}:{$this->guid}",
				'parent_name' => "{$parent->getName()}",
				'text' => "<img class=\"hj-categories-tree-icon\" src=\"{$this->getIconURL('tiny')}\" width=\"12\" />" . $this->title . ' (' . $this->getFiledEntitiesCount() . ')',
				'href' => $this->getURL(),
				'class' => 'hj-categories-menu-child',
				'priority' => $this->priority,
				'data' => array('category_guid' => $this->guid)
			);
		} else {
			$menu_item = array(
				'name' => "$this->guid",
				'text' => "<img class=\"hj-categories-tree-icon\" src=\"{$this->getIconURL('tiny')}\" width=\"12\" />" . $this->title . ' (' . $this->getFiledEntitiesCount() . ')',
				'href' => $this->getURL(),
				'class' => 'hj-categories-menu-root',
				'priority' => $this->priority,
				'data' => array('category_guid' => $this->guid)
			);
		}
		$menu_item = ElggMenuItem::factory($menu_item);
		$return[] = $menu_item;

		// Empty menu item to create html markup
		if ($this->canEdit() && elgg_get_context() == 'category') {
			$add_new = array(
				'name' => "{$menu_item->getName()}:addnew",
				'parent_name' => "{$menu_item->getName()}",
				'text' => '',
				'item_class' => 'hidden',
				'href' => false,
				'priority' => 1
			);
			$return[] = ElggMenuItem::factory($add_new);
		}

		if (!$top_only) {
			$children = $this->getChildren();
			if (is_array($children)) {
				foreach ($children as $child) {
					$submenu = $child->getMenuItem($menu_item);
					if (is_array($submenu)) {
						foreach ($submenu as $submenu_item) {
							$return[] = $submenu_item;
						}
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Gets children categories of a given category
	 *
	 * @param int $container_guid
	 * @return mixed array of children category objects
	 */
	public function getChildren() {

		$type = 'object';
		$subtype = 'hjcategory';
		$owner_guid = NULL;
		$container_guid = $this->guid;
		$limit = 0;
		$objects = hj_framework_get_entities_by_priority($type, $subtype, $owner_guid, $container_guid, $limit);

		if (is_array($objects)) {
			return $objects;
		}
		return false;
	}

	/**
	 * Get parent category for a given subcategory
	 *
	 * @return object hjCategory
	 */
	public function getParent() {
		$parent_guid = $this->container_guid;
		$parent = get_entity($parent_guid);
		if (elgg_instanceof($parent, 'object', 'hjcategory')) {
			return $parent;
		}
		return false;
	}

	/**
	 * Get entities filed in a given category
	 *
	 * @return array Array of objects
	 */
	public function getFiledEntities() {

		$objects = elgg_get_entities_from_relationship(array(
			'relationship' => 'filed_in',
			'relationship_guid' => $this->guid,
			'inverse_relationship' => true,
			'limit' => 0
				));
		return $objects;
	}

	/**
	 * Get entities filed in a given category by their types and subtypes
	 *
	 * @param mixed $types
	 * @param mixed $subtypes
	 * @return array
	 */
	public function getFiledEntitiesByType($types, $subtypes) {

		$objects = elgg_get_entities_from_relationship(array(
			'types' => $types,
			'subtypes' => $subtypes,
			'relationship' => 'filed_in',
			'relationship_guid' => $this->guid,
			'inverse_relationship' => true,
			'limit' => 0
				));

		return $objects;
	}

	/**
	 * Get a count of entities in a given category
	 *
	 * @return int
	 */
	public function getFiledEntitiesCount($types = NULL, $subtypes = NULL) {
		$objects = elgg_get_entities_from_relationship(array(
			'types' => $types,
			'subtypes' => $subtypes,
			'relationship' => 'filed_in',
			'relationship_guid' => $this->guid,
			'inverse_relationship' => true,
			'count' => true
				));
		return $objects;
	}


}
