<?php 
/**
 * Checks if the logged in user has a open or closed collapsed state relationship with a given widget 
 * 
 * @param int    $widget_guid guid of the widget to check
 * @param string $state       state to check
 * 
 * @return bool
 */
function widget_manager_check_collapsed_state($widget_guid, $state) {
	static $collapsed_widgets_state;
	$user_guid = elgg_get_logged_in_user_guid();
	
	if (empty($user_guid)) {
		return false;
	}
	
	if (!isset($collapsed_widgets_state)) {
		$collapsed_widgets_state = array();
		$dbprefix = elgg_get_config("dbprefix");
		
		$query = "SELECT * FROM {$dbprefix}entity_relationships WHERE guid_one = $user_guid AND relationship IN ('widget_state_collapsed', 'widget_state_open')";
		$result = get_data($query);
		if ($result) {
			foreach ($result as $row) {
				if (!isset($collapsed_widgets_state[$row->guid_two])) {
					$collapsed_widgets_state[$row->guid_two] = array();
				}
				$collapsed_widgets_state[$row->guid_two][] = $row->relationship;
			}
		}
	}
	
	if (!array_key_exists($widget_guid, $collapsed_widgets_state)) {
		return false;
	}
	
	if (in_array($state, $collapsed_widgets_state[$widget_guid])) {
		return true;
	}
	
	return false;
}
?>