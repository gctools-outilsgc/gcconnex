<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$sort_field = get_input('sort_field');
$order_field = get_input('order_field');

$_SESSION['missions_sort_field_value'] = $sort_field;
$_SESSION['missions_order_field_value'] = $order_field;

forward(REFERER);