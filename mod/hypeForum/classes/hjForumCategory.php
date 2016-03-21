<?php

class hjForumCategory extends hjCategory {

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = "hjforumcategory";
	}

	public function save() {
		return parent::save();
	}

	public function getURL() {
		return $this->getContainerEntity()->getURL();
	}

}

?>
