<?php

class hjFileFolder extends ElggObject {

	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "hjfilefolder";
	}

	public function getContainedFiles($subtype = 'hjfile', $count = false) {
		$files = hj_framework_get_entities_by_priority(array(
			'type' => 'object',
			'subtype' => $subtype,
			'container_guid' => $this->guid
				));
		if ($count) {
			$files = sizeof($files);
		}
		return $files;
	}

    public function getDataTypes() {
        $types = hj_framework_forms_filefolder_types();
        return $types;
    }

}
