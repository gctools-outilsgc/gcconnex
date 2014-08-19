<?php

/**
 *
 */
class PhloorFavicon extends PhloorElggThumbnails {

    /**
     * Set subtype to news.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype']   = "phloor_favicon";
        $this->attributes['access_id'] = ACCESS_PUBLIC;
    }

}