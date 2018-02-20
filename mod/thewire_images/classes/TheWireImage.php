<?php
/**
 * The wire image object
 */
class TheWireImage extends ElggFile {

	/**
	 * Override the subtype
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = 'thewire_image';
	}
}