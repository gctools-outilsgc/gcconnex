<?php

/**
 * Provide a way of setting your timezone
 *
 * @package Elgg
 * @subpackage Core
 *
 * GC_MODIFICATION
 * Description: Added tomezone option
 * Author: GCTools Team
 */
$user = elgg_get_page_owner_entity();
$content = '<label for="language">' . elgg_echo('user:timezone:label') . ': </label>';

if ($user) {
	$title = elgg_echo('user:set:timezone');
    function generate_timezone_list()
    {
        static $regions = array(
            DateTimeZone::AFRICA,
            DateTimeZone::AMERICA,
            DateTimeZone::ANTARCTICA,
            DateTimeZone::ASIA,
            DateTimeZone::ATLANTIC,
            DateTimeZone::AUSTRALIA,
            DateTimeZone::EUROPE,
            DateTimeZone::INDIAN,
            DateTimeZone::PACIFIC,
        );
    
        $timezones = array();
        foreach( $regions as $region )
        {
            $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
        }
    
        $timezone_offsets = array();
        foreach( $timezones as $timezone )
        {
            $tz = new DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
        }
    
        // sort timezone by offset
        asort($timezone_offsets);
    
        $timezone_list = array();
        foreach( $timezone_offsets as $timezone => $offset )
        {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate( 'H:i', abs($offset) );
    
            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
    
            $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
        }
    
        return $timezone_list;
    }
	// only make the admin user enter current password for changing his own password.
  
        // Create a list of timezone 
        $OptionsArray = generate_timezone_list(); 

   $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
   error_log('$OptionsArray'.print_r($OptionsArray,true));
	$content .= elgg_view("input/select", array(
		'name' => 'new_timezone',
        'id' => 'new_timezone',
		'value' => $user->new_timezone,
		'options_values' => $OptionsArray
	));
 
   // $content = select_Timezone();
	echo elgg_view_module('info', $title, $content);
}
