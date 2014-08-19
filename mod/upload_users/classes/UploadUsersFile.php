<?php

/**
 * Upload users file class
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @author Ismayil Khayredinov / Arck Interactive
 * @copyright Mediamaisteri Group 2009
 * @copyright ArckInteractive 2013
 * @link http://www.mediamaisteri.com/
 * @link http://arckinteractive.com/
 */
class UploadUsersFile extends ElggFile {

	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "upload_users_file";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}

	function parseCSVHeader() {
		if (($handle = fopen($this->getFilenameOnFilestore(), 'r')) !== FALSE) {
			return fgetcsv($handle, 0, $this->delimiter, $this->enclosure);
		}
		return false;
	}

	function parseCSV() {
		$data = array();
		if (($handle = fopen($this->getFilenameOnFilestore(), 'r')) !== FALSE) {
			while (($row = fgetcsv($handle, 0, $this->delimiter, $this->enclosure)) !== FALSE) {
				if (empty($headers)) {
					$headers = $row;
				} else {
					$data[] = array_combine($headers, $row);
				}
			}
			fclose($handle);
		}

		return $data;
	}

	function setHeaderMapping($mapping = array()) {
		$this->header_mapping = serialize($mapping);
	}

	function getHeaderMapping() {
		return (isset($this->header_mapping)) ? unserialize($this->header_mapping) : null;
	}

	function setRequiredFieldMapping($mapping = array()) {
		$this->required_fields_mapping = serialize($mapping);
	}

	function getRequiredFieldMapping() {
		return (isset($this->required_fields_mapping)) ? unserialize($this->required_fields_mapping) : null;
	}

	function setStatus($status = '') {
		$this->status = $status;
	}

	function getStatus() {
		return ($this->status) ? $this->status : 'uploaded';
	}

}
