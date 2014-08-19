<?php
/**
 * TidypicsBatch class
 *
 */

class TidypicsBatch extends ElggObject {

  protected function initializeAttributes() {

    parent::initializeAttributes();

    $this->attributes['subtype'] = "tidypics_batch";
  }

  public function __construct($guid = null) {

    parent::__construct($guid);
  }
}
