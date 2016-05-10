<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Removes a department's data from the analytics graph.
 */
$position = get_input('dep_pos');
$state_number = get_input('state_num');
$data_array = $_SESSION['mission_graph_data_array'];
$name_array = $_SESSION['mission_graph_name_array'];

unset($data_array[$position]);
$data_array = array_values($data_array);
$_SESSION['mission_graph_data_array'] = $data_array;

for($i=1;$i<=$state_number;$i++) {
	$num_temp = $state_number * ($position - 1) + $i;
	unset($name_array[$num_temp]);
}
$name_array = array_values($name_array);
$_SESSION['mission_graph_name_array'] = $name_array;

forward(REFERER);