<?php

/**
 *
 */
class PhloorElggThumbnails extends AbstractPhloorElggThumbnails {
    public function __construct($guid = null) {
        parent::__construct($guid);
    }

    /**
     * Set subtype to news.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = "phloor_elgg_thumbnails";
    }

    public function deleteImage() {
        if($this->canEdit()) {
            return parent::deleteImage();
        }
    }

}