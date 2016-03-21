<?php

class hjObject extends ElggObject {

	/**
	 * Perform generic actions and add generic metadata to the entity
	 * @return mixed
	 */
	public function save() {
		return parent::save();
	}

	/**
	 * Delete entity
	 * @return mixed
	 */
	public function delete($recursive = true) {
		return parent::delete($recursive);
	}

	/**
	 * Get full view URL
	 */
	public function getURL() {
		$friendly_title = elgg_get_friendly_title($this->getTitle());
		return elgg_get_site_url() . "framework/view/$this->guid/$friendly_title";
	}

	/**
	 * Get Icon URL
	 * @param str $size
	 * @return str
	 */
	public function getIconURL($size = 'medium') {
		if ($this->icontime) {
			return elgg_get_config('url') . "framework/icon/$this->guid/$size/$this->icontime.jpg";
		}
		return parent::getIconURL($size);
	}

	/**
	 * Get entity edit page URL
	 * @return str
	 */
	public function getEditURL() {
		return elgg_get_site_url() . "framework/edit/$this->guid";
	}

	/**
	 * Get entity delete action URL
	 * @return str
	 */
	public function getDeleteURL() {
		return elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/framework/delete/object?guid=$this->guid");
	}

	/**
	 * Get bookmark action URL
	 * @return str
	 */
	public function getBookmarkURL() {
		return elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/framework/bookmark?guid=$this->guid");
	}

	/**
	 * Get subscribe action URL
	 * @return str
	 */
	public function getSubscriptionURL() {
		return elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/framework/subscription?guid=$this->guid");
	}

	/**
	 * Add entity to a category
	 * @param int $category_guid
	 * @param bool $recursive	Traverse up the category tree?
	 */
	public function setCategory($category_guid, $recursive = true) {
		$category = get_entity($category_guid);
		while ($category instanceof hjCategory) {
			if (!check_entity_relationship($this->guid, 'filed_in', $category->guid)) {
				add_entity_relationship($this->guid, 'filed_in', $category->guid);
			}

			// i am guessing this moves everything that is under the entity to new category
			if ($recursive) {
				$category = $category->getContainerEntity();
			} else {
				$category = null;
			}
		}
	}

	/**
	 * Remove entity from category
	 * @param int $category_guid
	 * @param bool $recursive
	 */
	public function unsetCategory($category_guid, $recursive = true) {
		$category = get_entity($category_guid);
		while ($category instanceof hjCategory) {
			if (!check_entity_relationship($this->guid, 'filed_in', $category->guid)) {
				remove_entity_relationship($this->guid, 'filed_in', $category->guid);
			}
			if ($recursive) {
				$category = $category->getContainerEntity();
			} else {
				$category = null;
			}
		}
	}

	/**
	 * Get categories
	 * @param mixed $subtype
	 */
	public function getCategories($subtypes = array('hjcategory')) {

		return elgg_get_entities_from_relationship(array(
					'types' => 'object',
					'subtypes' => $subtypes,
					'limit' => 0,
					'relationship' => 'filed_in',
					'relationship_guid' => $this->guid
				));
	}

	/**
	 * Update ancestry relationships
	 * @see hj_framework_set_ancestry()
	 * @return array			Hierarchy of ancestors
	 */
	public function setAncestry() {
		return hj_framework_set_ancestry($this->guid);
	}

	/**
	 * Get ancestry relationships
	 * @see hj_framework_set_ancestry()
	 * @return array			Hierarchy of ancestors
	 */
	public function getAncestry() {
		return hj_framework_get_ancestry($this->guid);
	}

	/**
	 * Get entity title
	 * @return type
	 */
	public function getTitle() {
		if (isset($this->title_key) && !empty($this->title_key)) {
			return elgg_echo($this->title_key);
		}
		return $this->title;
	}

	/**
	 * Log entity view as annotation
	 * @param string $name
	 * @return type
	 */
	public function logView() {
		return $this->annotate('log:view', 1, ACCESS_PUBLIC);
	}

	/**
	 * Log entity preview as annotation
	 * @param string $name
	 * @return type
	 */
	public function logPreview() {
		return $this->annotate('log:preview', 1, ACCESS_PUBLIC);
	}

	/**
	 * Count logged views
	 * @return int
	 */
	public function countTotalViews() {
		return $this->getAnnotationsSum('log:view');
	}

	/**
	 * Count logged previews
	 * @return int
	 */
	public function countTotalPreviews() {
		return $this->getAnnotationsSum('log:preview');
	}

	/**
	 * Subscribe user to notifications
	 *
	 * @param mixed $user
	 * @return boolean
	 */
	public function createSubscription($user = null) {
		if (!$user) {
			$user = elgg_get_logged_in_user_entity();
		}

		if (!$this->isSubscribed()) {
			return add_entity_relationship($user->guid, 'subscribed', $this->guid);
		}

		return false;
	}

	/**
	 * Unsubscribe user from notifications
	 *
	 * @param mixed $user
	 * @return boolean
	 */
	public function removeSubscription($user = null) {
		if (!$user) {
			$user = elgg_get_logged_in_user_entity();
		}

		if ($this->isSubscribed()) {
			return remove_entity_relationship($user->guid, 'subscribed', $this->guid);
		}

		return false;
	}

	/**
	 * Check subscription status
	 *
	 * @param mixed $user
	 * @return boolean
	 */
	public function isSubscribed($user = null) {
		if (!$user) {
			$user = elgg_get_logged_in_user_entity();
		}

		return check_entity_relationship($user->guid, 'subscribed', $this->guid);
	}

	/**
	 * Get a list of users subscribed to this entity
	 * @return type
	 */
	public function getSubscribedUsers() {

		$options = array(
			'type' => 'user',
			'relationship' => 'subscribed',
			'relationship_guid' => $this->guid,
			'inverse_relationship' => true,
			'limit' => 0
		);

		$users = elgg_get_entities_from_relationship($options);

		return $users;
	}

	/**
	 * Bookmark entity
	 *
	 * @param mixed $user
	 * @return boolean
	 */
	public function createBookmark($user = null) {
		if (!$user) {
			$user = elgg_get_logged_in_user_entity();
		}

		if (!$this->isBookmarked()) {
			return add_entity_relationship($user->guid, 'bookmarked', $this->guid);
		}

		return false;
	}

	/**
	 * Remove bookmark
	 *
	 * @param mixed $user
	 * @return boolean
	 */
	public function removeBookmark($user = null) {
		if (!$user) {
			$user = elgg_get_logged_in_user_entity();
		}

		if ($this->isBookmarked()) {
			return remove_entity_relationship($user->guid, 'bookmarked', $this->guid);
		}

		return false;
	}

	/**
	 * Check if entity has been bookmarked
	 *
	 * @param mixed $user
	 * @return boolean
	 */
	public function isBookmarked($user = null) {
		if (!$user) {
			$user = elgg_get_logged_in_user_entity();
		}

		return check_entity_relationship($user->guid, 'bookmarked', $this->guid);
	}

	/**
	 * Set last action on an entity | helpful when updating a parent entity
	 * @param int $timestamp
	 */
	public function setLastAction($timestamp = null) {

		if (!$timestamp) {
			$timestamp = time();
		}

		update_entity_last_action($this->guid, $timestamp);
	}

}