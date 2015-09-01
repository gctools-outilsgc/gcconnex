<?php

/**
 * Class for MultiDashboard objects
 *
 * @package WidgetManager
 */
class MultiDashboard extends ElggObject {
	
	const SUBTYPE = "multi_dashboard";
	const WIDGET_RELATIONSHIP = "on_dashboard";
	
	private $allowed_dashboard_types = array(
		"widgets",
		"iframe",
		"internal"
	);
	
	/**
	 * Initializes the attributes for this object
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes["subtype"] = self::SUBTYPE;
	}
	
	/**
	 * Correctly sets attributes on save
	 *
	 * @return void
	 */
	function save() {
		if (!$this->guid) {
			$this->attributes["owner_guid"] = elgg_get_logged_in_user_guid();
			$this->attributes["container_guid"] = elgg_get_logged_in_user_guid();
			$this->attributes["access_id"] = ACCESS_PRIVATE;
		}
		
		return parent::save();
	}
	
	/**
	 * Returns url to the dashboard
	 *
	 * @return string|boolean
	 */
	function getURL() {
		$result = false;
			
		if ($this->guid) {
			$site = elgg_get_site_entity($this->site_guid);
	
			$result = $site->url . "dashboard/" . $this->getGUID();
		}
			
		return $result;
	}
	
	/**
	 * On delete of dashboard remove all widgets in it
	 *
	 * @param boolean $recursive Whether to delete all the entities contained by this entity
	 *
	 * @return boolean
	 */
	function delete($recursive = true) {
		if ($widgets = $this->getWidgets(false)) {
			foreach ($widgets as $col => $col_widgets) {
				if (!empty($col_widgets)) {
					foreach ($col_widgets as $widget) {
						$widget->delete();
					}
				}
			}
		}
		return parent::delete($recursive);
	}
	
	/**
	 * Sets the type of this dashboard
	 *
	 * @param string $type type of the dashboard (defaults to widgets)
	 *
	 * @return boolean
	 */
	function setDashboardType($type = "widgets") {
		$result = false;
		
		if (in_array($type, $this->allowed_dashboard_types)) {
			$result = $this->set("dashboard_type", $type);
		}
		
		return $result;
	}
	
	/**
	 * Returns the type of dashboard
	 *
	 * @return string
	 */
	function getDashboardType() {
		return $this->dashboard_type;
	}
	
	/**
	 * Sets the number of columns
	 *
	 * @param int $num number of columns
	 *
	 * @return boolean
	 */
	function setNumColumns($num = 3) {
		$result = false;
		$num = sanitise_int($num);
		
		if (!empty($num) && $num <= 6) {
			$result = $this->set("num_columns", $num);
		}
		
		return $result;
	}
	
	/**
	 * Returns the number of columns
	 *
	 * @return int
	 */
	function getNumColumns() {
		return $this->num_columns;
	}
	
	/**
	 * Sets the iframe url
	 *
	 * @param string $url url of the iframe
	 *
	 * @return boolean
	 */
	function setIframeUrl($url) {
		$result = false;
		
		if (!empty($url)) {
			$result = $this->set("iframe_url", $url);
		}
		
		return $result;
	}
	
	/**
	 * Returns the iframe url
	 *
	 * @return string
	 */
	function getIframeUrl() {
		return $this->iframe_url;
	}
	
	/**
	 * Sets the iframe height
	 *
	 * @param int $height height of the iframe (in pixels)
	 *
	 * @return boolean
	 */
	function setIframeHeight($height) {
		$result = false;
		$height = sanitise_int($height);
		
		if (!empty($height)) {
			$result = $this->set("iframe_height", $height);
		}
		
		return $result;
	}
	
	/**
	 * Returns the iframe height
	 *
	 * @return int
	 */
	function getIframeHeight() {
		return $this->iframe_height;
	}
	
	/**
	 * Sets the internal url
	 *
	 * @param string $url url of the internal page
	 *
	 * @return boolean
	 */
	function setInternalUrl($url) {
		$result = false;
		
		if (!empty($url)) {
			$result = $this->set("internal_url", $url);
		}
		
		return $result;
	}
	
	/**
	 * Returns the internal url
	 *
	 * @return boolean|string
	 */
	function getInternalUrl() {
		$result = false;
		
		if ($url = $this->internal_url) {
			$result = elgg_http_add_url_query_elements($url, array("view" => "internal_dashboard"));
		}
		
		return $result;
	}
	
	/**
	 * Returns widgets for this dashboard
	 *
	 * @param boolean $check_type do a type check
	 *
	 * @return boolean|array
	 */
	function getWidgets($check_type = true) {
		$result = false;
		
		if (($check_type && ($this->getDashboardType() == "widgets")) || !$check_type) {
			$result = array();
			
			$options = array(
				"type" => "object",
				"subtype" => "widget",
				"limit" => false,
				"owner_guid" => $this->owner_guid,
				"relationship" => self::WIDGET_RELATIONSHIP,
				"relationship_guid" => $this->guid,
				"inverse_relationship" => true
			);
			
			if ($widgets = elgg_get_entities_from_relationship($options)) {
				
				foreach ($widgets as $widget) {
					$col = (int) $widget->column;
					$order = (int) $widget->order;
					
					if (!isset($result[$col])) {
						$result[$col] = array();
					}
					
					$result[$col][$order] = $widget;
				}
				
				foreach ($result as $col => $widgets) {
					ksort($result[$col]);
				}
			}
		}
		
		return $result;
	}
}
