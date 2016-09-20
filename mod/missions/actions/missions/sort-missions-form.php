<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action which sets session variables which determine what value missions are sorted by and whether they're in ascending or descending order.
 */
$sort_field = get_input('sort_field');
$order_field = get_input('order_field');
$opp_field = get_input('opp_filter');


$_SESSION['missions_sort_field_value'] = $sort_field;
$_SESSION['missions_order_field_value'] = $order_field;
$_SESSION['missions_type_field_value'] = $opp_field;
forward(REFERER);