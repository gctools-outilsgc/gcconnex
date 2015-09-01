<?php

class hjForum extends hjObject {

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = "hjforum";
	}

	public function save() {
		if (!$this->guid) {
			$return = parent::save();

			if ($return) {
				$this->setAncestry();
				$this->notifySubscribedUsers();
			}

			return $return;
		}

		return parent::save();
	}

	public function countTopics($recursive = false) {
		return $this->getLatestTopics(0, true, $recursive);
	}

	public function countPosts($recursive = false) {
		return $this->getLatestPosts(0, true, $recursive);
	}

	public function getLatestTopics($limit = 10, $count = false, $recursive = false) {
		return hj_forum_get_latest_topics($this->guid, $limit, $count, $recursive);
	}

	public function getLatestTopic($recursive = false) {
		$topics = $this->getLatestTopics(1, false, $recursive);
		return ($topics) ? $topics[0] : false;
	}

	public function getLatestPosts($limit = 10, $count = false, $recursive = false) {
		return hj_forum_get_latest_posts($this->guid, $limit, $count, $recursive);
	}

	public function getLatestPost($recursive = false) {
		$posts = $this->getLatestPosts(1, false, $recursive);
		return ($posts) ? $posts[0] : false;
	}

	public function getURL() {
		$friendly_title = elgg_get_friendly_title($this->getTitle());
		return elgg_get_site_url() . "forum/view/$this->guid/$friendly_title";
	}

	public function getEditURL() {
		return elgg_get_site_url() . "forum/edit/$this->guid";
	}

	public function isOpenFor($subtype = null) {

		if ($this->status == 'closed')
			return false;

		return true;
	}

	public function isSticky() {
		if ($this->sticky == true) {
			return true;
		}

		return false;
	}

	public function hasCategories() {
		$options = array(
			'types' => 'object',
			'subtypes' => 'hjforumcategory',
			'count' => true,
			'container_guid' => $this->guid
		);

		$categories = elgg_get_entities($options);

		return ($categories);
	}

	public function notifySubscribedUsers() {
		return hj_forum_notify_subscribed_users($this->guid);
	}

}

