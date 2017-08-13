<?php

$background_colour = '#F5F5F5';
$highlight_colour = '#3874B7';
?>

.elgg-menu-site {
	z-index: 50;
}

#calendarmenucontainer {
	position:relative;
	left: 25px;
}

ul#calendarmenu li {
	float: left;
	border-top: 1px solid #969696;
	border-left: 1px solid #969696;
	border-bottom: 1px solid #969696;
	background-color: <?php echo $background_colour; ?>;
}


ul#calendarmenu li.sys_calmenu_last {
	border-right: 1px solid #969696;
}

ul#calendarmenu li a {
	text-decoration: none;
	padding: 4px 12px;
	float: left;
}

ul#calendarmenu li a:hover, ul#calendarmenu li.sys_selected a{
	text-decoration: none;
	padding: 4px 12px;
	float: left;
	color: #FFFFFF;
	background: <?php echo $highlight_colour; ?>;
}

td.ui-datepicker-unselectable {
	background-color: #FFFFFF !important;
	color: #888888 !important;
}

#my_datepicker .week-highlight a {
	text-decoration: none;
	color: #FFFFFF;
	background: <?php echo $highlight_colour; ?>;
}

#event_list {
	max-width:485px;
	margin:0;
	float:left;
	padding:5px 0 0 0;
}
#event_list .search_listing {
	border:2px solid #cccccc;
	margin:0 0 5px 0;
}

.events {
	min-height: 300px;
}

div.event_calendar_agenda_date_section {
	margin-bottom: 10px;
}

.event_calendar_agenda_date {
	font-size: 1.3em;
	font-weight: bold;
	margin-bottom: 3px;
}

th.agenda_header {
	font-weight: bold;
}

td.event_calendar_agenda_time {
	width: 120px;
}

.event_calendar_agenda_title a {
	font-weight: bold;
}

td.event_calendar_agenda_title {
	width: 180px;
}

.event_calendar_agenda_venue {
	margin-bottom: 5px;
}

.event_calendar_paged_month {
	font-size: 1.3em;
	font-weight: bold;
	margin-bottom: 5px;
	text-transform:uppercase;
}

td.event_calendar_paged_date {
	width: 80px;
}
td.event_calendar_paged_time {
	width: 60px;
}
td.event_calendar_paged_title {
	width: 280px;
}

td.event_calendar_paged_calendar {
	padding-left: 30px;
}

table.event_calendar_paged_table {
	width:100%;
	border-collapse:collapse;
	border-bottom-width:1px;
	border-bottom-style:solid;
	border-bottom-color:#bfbfbf;
	margin-bottom: 5px;
}

table.event_calendar_paged_table td {
	border-width:1px 0 0 0;
	border-style:solid;
	border-color:#bfbfbf;
}

table.event_calendar_paged_table th {
	font-family:verdana, helvetica, arial, sans-serif;
	font-size:9pt;
	color:#183e76;
	background-color:#ececec;
	font-weight:bold;
	text-transform:none;
	padding:3px 3px 3px 3px;
}

.event-calendar-personal-calendar-toggle {
	float: right;
}

li.event-calendar-filter-menu-show-only {
	border:0;
	padding-top:.4em;
	background:#fff;
	margin:0 -.3em 0 1.5em;
}

.event-calendar-compressed-date {
	width: 150px !important;
	margin-right: 10px;
}

.event-calendar-edit-form-other-block .mceLayout,
.event-calendar-edit-form-other-block .mce-tinymce  {
	float:none;
	clear:both;
	width: 100% !important;
}

.event-calendar-edit-form-share label {
	float:none;
	clear:both;
	width: 100% !important;
}

.event-calendar-edit-form {
	
}

.event-calendar-edit-form-block {
	width: 98%;
	border-bottom: 1px solid #CCC;
	padding: 5px;
	margin-bottom: 10px;
	clear: both;
}

.event-calendar-repeating-wrapper {
	padding: 0;
	margin-top: 5px;
}
.event-calendar-repeating-unselected {
	font-size: 16px;
	font-weight: bold;
	color: #DDDDDD;
	background-color: #AAAAAA;
	border: 1px solid #444444;
	padding: 5px;
	width: 25px;
	text-align: center;
	display: inline-block;
	margin: 0;
}

.event-calendar-repeating-unselected:hover {
	text-decoration: none;
}

.event-calendar-repeating-selected {
	font-size: 16px;
	font-weight: bold;
	color: #000000;
	background-color: #FFFFFF;
	border: 1px solid #000000;
	padding: 5px;
	width: 25px;
	text-align: center;
	display: inline-block;
	margin: 0;
}

.event-calendar-repeating-selected:hover {
	text-decoration: none;
	color: #CCCCCC;
}

.event-calendar-edit-form-block ul.elgg-vertical li label {
	font-weight: normal;
	width: 500px;
}

.event-calendar-edit-form-block h2 {
	font-size: 18px;
	color: #000000;
}

.event-calendar-edit-date-wrapper, .event-calendar-edit-all-day-date-wrapper {
	clear: both;
	margin-left: 20px;
	display: none;
}

.event-calendar-edit-reminder-wrapper {
	margin-top: 10px;
	display: none;
}

.event-calendar-edit-form-membership-block, .event-calendar-edit-form-share-block {
	display: none;
}

.event-calendar-description {
	display: none;
}

.event-calendar-edit-bottom {
	clear: both;
	margin-bottom: 5px;
}

.event-calendar-date-selected {
	background-color: #DDDDFF;
}
.elgg-gallery > li {
	border-bottom:1px dotted rgb(204,204,204);
}

.event-calendar-repeat-section {
	padding-top: 15px;
	clear: both;
}
