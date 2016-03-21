<?php

$background_colour = '#F5F5F5';
$highlight_colour = '#3874B7';
?>

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

.river_object_event_calendar_create {
	background: url(<?php echo elgg_get_site_url(); ?>mod/event_calendar/images/river_icon_event.gif) no-repeat left -1px;
}
.river_object_event_calendar_update {
	background: url(<?php echo elgg_get_site_url(); ?>mod/event_calendar/images/river_icon_event.gif) no-repeat left -1px;
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
	<!-- background-color: #DDDDDD; -->
	<!-- border-width:1px; -->
	border-style:solid;
	border-color:#bfbfbf;
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



.ui-datepicker { width: 17em; padding: .2em .2em 0; display: none; }
.ui-datepicker .ui-datepicker-header { position:relative; padding:.2em 0; }
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next { position:absolute; top: 2px; width: 1.8em; height: 1.8em; }
.ui-datepicker .ui-datepicker-prev-hover, .ui-datepicker .ui-datepicker-next-hover { top: 1px; }
.ui-datepicker .ui-datepicker-prev { left:2px; }
.ui-datepicker .ui-datepicker-next { right:2px; }
.ui-datepicker .ui-datepicker-prev-hover { left:1px; }
.ui-datepicker .ui-datepicker-next-hover { right:1px; }
.ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span { display: block; position: absolute; left: 50%; margin-left: -8px; top: 50%; margin-top: -8px;  }
.ui-datepicker .ui-datepicker-title { margin: 0 2.3em; line-height: 1.8em; text-align: center; }
.ui-datepicker .ui-datepicker-title select { font-size:1em; margin:1px 0; }
.ui-datepicker select.ui-datepicker-month-year {width: 100%;}
.ui-datepicker select.ui-datepicker-month, 
.ui-datepicker select.ui-datepicker-year { width: 49%;}
.ui-datepicker table {width: 100%; font-size: .9em; border-collapse: collapse; margin:0 0 .4em; }
.ui-datepicker th { padding: .7em .3em; text-align: center; font-weight: bold; border: 0;  }
.ui-datepicker td { border: 0; padding: 1px; }
.ui-datepicker td span, .ui-datepicker td a { display: block; padding: .2em; text-align: right; text-decoration: none; }
.ui-datepicker .ui-datepicker-buttonpane { background-image: none; margin: .7em 0 0 0; padding:0 .2em; border-left: 0; border-right: 0; border-bottom: 0; }
.ui-datepicker .ui-datepicker-buttonpane button { float: right; margin: .5em .2em .4em; cursor: pointer; padding: .2em .6em .3em .6em; width:auto; overflow:visible; }
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current { float:left; }



.ui-widget { font-family: Verdana,Arial,sans-serif; font-size: 1em; }
.ui-widget .ui-widget { font-size: 1em; }
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button { font-family: Verdana,Arial,sans-serif; font-size: 1em; }
.ui-widget-content { border: 1px solid #aaaaaa; background: #ffffff url(images/ui-bg_flat_75_ffffff_40x100.png) 50% 50% repeat-x; color: #222222; }
.ui-widget-content a { color: #222222; }
.ui-widget-header { border: 1px solid #aaaaaa; background: #cccccc url(images/ui-bg_flat_75_cccccc_40x100.png) 50% 50% repeat-x; color: #222222; font-weight: bold; }
.ui-widget-header a { color: #222222; }

.ui-helper-clearfix:before, .ui-helper-clearfix:after { content: ""; display: table; }
.ui-helper-clearfix:after { clear: both; }
.ui-helper-clearfix { zoom: 1; }

.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl { -moz-border-radius-topleft: 0; -webkit-border-top-left-radius: 0; -khtml-border-top-left-radius: 0; border-top-left-radius: 0; }
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr { -moz-border-radius-topright: 0; -webkit-border-top-right-radius: 0; -khtml-border-top-right-radius: 0; border-top-right-radius: 0; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl { -moz-border-radius-bottomleft: 0; -webkit-border-bottom-left-radius: 0; -khtml-border-bottom-left-radius: 0; border-bottom-left-radius: 0; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br { -moz-border-radius-bottomright: 0; -webkit-border-bottom-right-radius: 0; -khtml-border-bottom-right-radius: 0; border-bottom-right-radius: 0; }

.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: 1px solid #d3d3d3; background: #e6e6e6 url(images/ui-bg_flat_75_e6e6e6_40x100.png) 50% 50% repeat-x; font-weight: normal; color: #555555; }
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: #555555; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #999999; background: #dadada url(images/ui-bg_flat_75_dadada_40x100.png) 50% 50% repeat-x; font-weight: normal; color: #212121; }
.ui-state-hover a, .ui-state-hover a:hover { color: #212121; text-decoration: none; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active { border: 1px solid #aaaaaa; background: #ffffff url(images/ui-bg_flat_65_ffffff_40x100.png) 50% 50% repeat-x; font-weight: normal; color: #212121; }
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #212121; text-decoration: none; }
.ui-widget :active { outline: none; }

.ui-icon-circle-triangle-e { background-position: -48px -192px; }
.ui-icon-circle-triangle-s { background-position: -64px -192px; }
.ui-icon-circle-triangle-w { background-position: -80px -192px; }
.ui-icon-circle-triangle-n { background-position: -96px -192px; }

.ui-icon { width: 16px; height: 16px; background-image: url(images/ui-icons_222222_256x240.png); }
.ui-widget-content .ui-icon {background-image: url(images/ui-icons_222222_256x240.png); }
.ui-widget-header .ui-icon {background-image: url(images/ui-icons_222222_256x240.png); }
.ui-state-default .ui-icon { background-image: url(images/ui-icons_888888_256x240.png); }
.ui-state-hover .ui-icon, .ui-state-focus .ui-icon {background-image: url(images/ui-icons_454545_256x240.png); }
.ui-state-active .ui-icon {background-image: url(images/ui-icons_454545_256x240.png); }
.ui-state-highlight .ui-icon {background-image: url(images/ui-icons_2e83ff_256x240.png); }
.ui-state-error .ui-icon, .ui-state-error-text .ui-icon {background-image: url(images/ui-icons_cd0a0a_256x240.png); }




 }