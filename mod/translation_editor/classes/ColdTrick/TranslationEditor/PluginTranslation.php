<?php

namespace ColdTrick\TranslationEditor;

class PluginTranslation {
	
	/**
	 * @var string $plugin_id
	 */
	protected $plugin_id;
	
	/**
	 * @var string $language
	 */
	protected $language;
	
	/**
	 * Constructor
	 *
	 * @param string $plugin_id plugin id
	 * @param string $language  language for the translations
	 *
	 * @throws \InvalidArgumentException
	 */
	public function __construct($plugin_id, $language = 'en') {
		$this->plugin_id = $plugin_id;
		$this->language = $language;
		
		if (empty($plugin_id)) {
			throw new \InvalidArgumentException('A plugin id must be set');
		}
		if (empty($language)) {
			throw new \InvalidArgumentException('A language must be set');
		}
	}

	/**
	 * Checks and creates folder structure if needed
	 */
	protected function createFolderStructure() {
		$base_dir = elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR;
		if (!file_exists($base_dir)) {
			mkdir($base_dir, 0755, true);
		}
		
		if (!file_exists($base_dir . $this->language . DIRECTORY_SEPARATOR)) {
			mkdir($base_dir . $this->language . DIRECTORY_SEPARATOR, 0755, true);
		}
	}
	
	/**
	 * Returns filename of the plugin translation file
	 *
	 * @return string
	 */
	protected function getFilename() {
		return elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR . $this->language . DIRECTORY_SEPARATOR . $this->plugin_id . '.json';
	}
	
	/**
	 * Write the custom translation for a plugin to disk
	 *
	 * @param array $translations
	 *
	 * @return false|int
	 */
	public function saveTranslations($translations = []) {
		$this->createFolderStructure();
				
		$contents = json_encode($translations);
	
		$bytes = file_put_contents($this->getFilename(), $contents);
		if (empty($bytes)) {
			return false;
		}
		
		return $bytes;
	}
	
	public function readTranslations() {
		
		$file_name = $this->getFilename();
		
		if (!file_exists($file_name)) {
			return false;
		}
		
		$contents = file_get_contents($file_name);
		if (empty($contents)) {
			return false;
		}
		
		return json_decode($contents, true);
	}
	
	/**
	 * Removes translation file
	 *
	 * @return boolean
	 */
	public function removeTranslations() {
		$filename = $this->getFilename();
	
		if (file_exists($filename)) {
			return unlink($filename);
		}
		
		return true;
	}
}
