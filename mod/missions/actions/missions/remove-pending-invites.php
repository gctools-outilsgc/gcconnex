<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * An action which removes all tentative relationships from the mission.
 */
$mid = get_input('mission_guid');

$relationships = get_entity_relationships($mid);

foreach($relationships as $relationship) {
    if($relationship->relationship == 'mission_tentative') {
        remove_entity_relationship($relationship->guid_one, 'mission_tentative', $relationship->guid_two);
    }
}

return(REFERER);