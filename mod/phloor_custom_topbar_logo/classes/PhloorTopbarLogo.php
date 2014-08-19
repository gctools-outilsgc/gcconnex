<?php

/**
 *
 */
class PhloorTopbarLogo extends PhloorElggThumbnails {

    /**
     * Set subtype to news.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype']   = "phloor_topbar_logo";
        $this->attributes['access_id'] = ACCESS_PUBLIC;
    }

}