<?php

class hjFile extends ElggFile {

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = "hjfile";
	}

	/**
	 * Get Icon URL
	 * @param str $size
	 * @return str
	 */
	public function getIconURL($size = 'medium') {
		if (isset($this->icontime)) {
			$url = "framework/icon/$this->guid/$size/$this->icontime.jpg";
		} else {
			$type = (isset($this->simpletype)) ? $this->simpletype : 'general';
			$url = "mod/hypeFramework/graphics/mime/{$size}/{$type}.png";
		}
		return elgg_normalize_url($url);
	}

	public function getURL() {
		$friendly_title = elgg_get_friendly_title($this->title);
		return elgg_normalize_url("framework/file/view/$this->guid/$friendly_title");
	}

	public function getEditURL() {
		return "framework/file/edit/$this->guid";
	}

	public function getDeleteURL() {
		return elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/framework/delete/object?guid=$this->guid");
	}

	public function getDownloadURL() {
		return elgg_normalize_url("framework/download/$this->guid");
	}

	public function delete() {

		$icon_sizes = hj_framework_get_thumb_sizes($this->getSubtype());

		$prefix_old = "hjfile/$this->container_guid/$this->guid";
		$prefix_old_alt = "hjfile/$this->guid";
		$prefix = "icons/$this->guid";

		foreach ($icon_sizes as $size => $values) {
			$thumb = new ElggFile();
			$thumb->owner_guid = elgg_get_logged_in_user_guid();
			$thumb->setFilename("$prefix$size.jpg");
			$thumb->delete();

			$thumb = new ElggFile();
			$thumb->owner_guid = elgg_get_logged_in_user_guid();
			$thumb->setFilename("$prefix_old$size.jpg");
			$thumb->delete();

			$thumb = new ElggFile();
			$thumb->owner_guid = elgg_get_logged_in_user_guid();
			$thumb->setFilename("$prefix_old_alt$size.jpg");
			$thumb->delete();
		}

		return parent::delete();
	}

}