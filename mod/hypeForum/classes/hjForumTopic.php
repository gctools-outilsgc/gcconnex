<?php

class hjForumTopic extends hjForum {

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = "hjforumtopic";
	}

	public function save() {
		if ($guid = parent::save()) {
			if (!isset($this->sticky)) {
				$this->sticky = 0;
			}
		}
		return $guid;
	}

}