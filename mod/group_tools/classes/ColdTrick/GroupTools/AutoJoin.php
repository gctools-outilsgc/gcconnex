<?php

namespace ColdTrick\GroupTools;

class AutoJoin {
	
	/**
	 * The user to try and match
	 *
	 * @var \ElggUser
	 */
	protected $user;
	
	/**
	 * The default auto join groups
	 *
	 * @var array
	 */
	protected $defaults;
	
	/**
	 * Conditional rules for auto joining
	 *
	 * @var array
	 */
	protected $configs;
	
	public function __construct(\ElggUser $user) {
		$this->user = $user;
		
		// load additional rules
		$this->configs = group_tools_get_auto_join_configurations();
	}
	
	/**
	 * Get the GUIDs of the groups the user can join
	 *
	 * @return int[]
	 */
	public function getGroupGUIDs() {
		
		// check exclusives
		$exclusives = $this->checkExclusives();
		if (!empty($exclusives)) {
			return $this->sanitiseGUIDS($exclusives);
		}
		
		// get defaults
		$defaults = $this->getDefaults();
		
		// check for additionals
		$additionals = $this->checkAdditionals();
		
		$guids = array_merge($defaults, $additionals);
		
		return $this->sanitiseGUIDS($guids);
	}
	
	/**
	 * Set the user to check for
	 *
	 * @param \ElggUser $user
	 *
	 * @return void
	 */
	public function setUser(\ElggUser $user) {
		$this->user = $user;
	}
	
	/**
	 * Get the exclusive groups to join
	 *
	 * @return int[]
	 */
	protected function checkExclusives() {
		
		foreach ($this->configs as $config) {
			
			if (elgg_extract('type', $config) !== 'exclusive') {
				continue;
			}
			
			$patterns = elgg_extract('patterns', $config);
			if (empty($patterns)) {
				continue;
			}
			
			if (!$this->checkConfigPatterns($patterns)) {
				continue;
			}
			
			return (array) elgg_extract('group_guids', $config, []);
		}
		
		return [];
	}
	
	/**
	 * Get the additional groups to join
	 *
	 * @return int[]
	 */
	protected function checkAdditionals() {
		
		$group_guids = [];
		
		foreach ($this->configs as $config) {
			
			if (elgg_extract('type', $config) !== 'additional') {
				continue;
			}
			
			$patterns = elgg_extract('patterns', $config);
			if (empty($patterns)) {
				continue;
			}
			
			if (!$this->checkConfigPatterns($patterns)) {
				continue;
			}
			
			$config_groups = (array) elgg_extract('group_guids', $config, []);
			$group_guids = array_merge($group_guids, $config_groups);
		}
		
		return $group_guids;
	}
	
	/**
	 * Validate the config patterns with the user
	 *
	 * @param array $patterns the patterns to match
	 *
	 * @return bool
	 */
	protected function checkConfigPatterns($patterns) {
		
		if (empty($patterns) || !is_array($patterns)) {
			return false;
		}
		
		$result = true;
		
		foreach ($patterns as $pattern) {
			$field = elgg_extract('field', $pattern);
			$value = elgg_extract('value', $pattern);
			$operand = elgg_extract('operand', $pattern);
			
			$user_value = $this->user->$field;
			if (!isset($user_value) || $user_value === '') {
				$result &= false;
			}
			
			if (is_array($user_value)) {
				foreach ($user_value as $v) {
					if ($this->checkUserValue($value, $operand, $v)) {
						// go to next pattern
						continue(2);
					}
				}
				
				$result &= false;
			} else {
				$result &= $this->checkUserValue($value, $operand, $user_value);
			}
		}
		
		return $result;
	}
	
	/**
	 * Check if a user value matches the expected value
	 *
	 * @param string $expected_value the configured matching value
	 * @param string $operand        the operand to use in the matching
	 * @param string $user_value     the user value
	 *
	 * @return bool
	 */
	protected function checkUserValue($expected_value, $operand, $user_value) {
		
		switch ($operand) {
			case 'equals':
				return strtolower($user_value) == strtolower($expected_value);
				break;
			case 'not_equals':
				return strtolower($user_value) != strtolower($expected_value);
				break;
			case 'contains':
				return (bool) stristr($user_value, $expected_value);
				break;
			case 'not_contains':
				return !(bool) stristr($user_value, $expected_value);
				break;
			case 'pregmatch':
				$valid = @preg_match('/' . $expected_value . '/', null);
				if (!$valid) {
					// preg match pattern is invalid
					// @note this shouldn't happen
					return false;
				}
				return (bool) preg_match('/' . $expected_value . '/', $user_value);
				break;
		}
		
		return false;
	}
	
	/**
	 * Make sure we only have guids
	 *
	 * @param array $guids the array to sanitise
	 *
	 * @return int[]
	 */
	protected function sanitiseGUIDS($guids) {
		
		if (empty($guids)) {
			return [];
		}
		
		if (!is_array($guids)) {
			$guids = [$guids];
		}
		
		$to_int = function ($value) {
			return (int) $value;
		};
		$positive = function ($value) {
			return $value > 0;
		};
		
		$guids = array_map($to_int, $guids);
		$guids = array_filter($guids, $positive);
		$guids = array_unique($guids);
		
		return $guids;
	}
	
	/**
	 * Only load the default groups when needed
	 *
	 * @return int[]
	 */
	protected function getDefaults() {
		
		if (isset($this->defaults)) {
			return $this->defaults;
		}
		
		// load default groups
		$this->defaults = [];
		
		$auto_joins = elgg_get_plugin_setting('auto_join', 'group_tools');
		if (!empty($auto_joins)) {
			$this->defaults = $this->sanitiseGUIDS(string_to_tag_array($auto_joins));
		}
		
		return $this->defaults;
	}
}
