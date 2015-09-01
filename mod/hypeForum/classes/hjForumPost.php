<?php

class hjForumPost extends hjForumTopic {

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = "hjforumpost";
	}

	public function save() {
		$return = parent::save();

		if ($return) {
			$this->getContainerEntity()->createSubscription();
		}

		return $return;
	}
	
	public function getURL() {
		return elgg_http_add_url_query_elements($this->getContainerEntity()->getURL(), array('__goto' => $this->guid)) . "#elgg-entity-$this->guid";
	}

}
