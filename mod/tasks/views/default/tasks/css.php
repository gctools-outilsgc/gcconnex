<?php
/**
 * Elgg Tasks CSS
 *
 * @package ElggTasks
 */
?>

.tasks-nav.treeview ul {
	background-color: transparent;
}

.tasks-nav.treeview a.selected {
	color: #555555;
}

.tasks-nav.treeview .hover {
	color: #0054a7;
}


<?php

	/**
	 * Elgg tasks CSS
	 * 
	 * @package Elggtasks
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */

?>

.sharing_item {

}

.sharing_item_owner {
	font-size: 90%;
	margin: 10px 0 0 0;
	color:#666666;
}

.sharing_item_owner .icon {
	float: left;
	margin-right: 5px;

}
.sharing_item_title h3 {
	font-size: 150%;
	margin-bottom: 5px;
}
.sharing_item_title h3 a {
	text-decoration: none;
}
.sharing_item_description p {
	margin:0;
	padding:0 0 5px 0;
}
.sharing_item_tags {
	background:transparent url(<?php echo elgg_get_site_url(); ?>_graphics/icon_tag.gif) no-repeat scroll left 2px;
	margin:0;
	padding:0 0 0 14px;
}

.sharing_item_address a {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#4690d6;
	border: 1px solid #4690d6;
	-webkit-border-radius: 3px; 
	-moz-border-radius: 3px;
	width: auto;
	height: 25px;
	padding: 2px 6px 2px 6px;
	margin:10px 0 10px 0;
	cursor: pointer;
}
.sharing_item_address a:hover {
	background: #0054a7;
	border: 1px solid #0054a7;
	text-decoration: none;
}
.sharing_item_controls p {
	margin:0;
}



/* SHARES WIDGET VIEW */
.shares_widget_wrapper {
	background-color: white;
	margin:0 10px 5px 10px;
	padding:5px;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
}
.shares_widget_icon {
	float: left;
	margin-right: 10px;
}
.shares_timestamp {
	color:#666666;
	margin:0;
}
.share_desc {
	display:none;
	line-height: 1.2em;
}
.shares_widget_content {
	margin-left: 35px;
}
.shares_title {
	margin:0;
	line-height: 1.2em;
}

/* timestamp and user info in gallery and list view */
.search_listing_info .shares_gallery_user,
.share_gallery_info .shares_gallery_user,
.share_gallery_info .shares_gallery_comments {
	color:#666666;
	margin:0;
	font-size: 90%;	
}


input.tiny {
	-moz-border-radius-bottomleft:4px;
	-moz-border-radius-bottomright:4px;
	-moz-border-radius-topleft:4px;
	-moz-border-radius-topright:4px;
	background-color:#FFFFFF;
	border:1px solid #BBBBBB;
	color:#999999;
	font-size:12px;
	font-weight:bold;
	/*height:12px;*/
	margin:0;
	padding:2px;
}
input.date{
	width:100px;
}
input.number, input.task_work_remaining, input.task_percent_done {
	-moz-border-radius-bottomleft:4px;
	-moz-border-radius-bottomright:4px;
	-moz-border-radius-topleft:4px;
	-moz-border-radius-topright:4px;
	background-color:#FFFFFF;
	border:1px solid #BBBBBB;
	color:#999999;
	/*font-size:12px;*/
	font-weight:bold;
	/*height:12px;*/
	margin:0;
	padding:2px;
	width:100px;
}

.tasks_resume {
	-moz-border-radius-bottomleft:4px;
	-moz-border-radius-bottomright:4px;
	-moz-border-radius-topleft:4px;
	-moz-border-radius-topright:4px;
	border:1px solid #CCCCCC;
	margin:0 0 15px;
	padding:2px;
	background:#EEEEEE none repeat scroll 0 0;
	/*font-size: 85%;*/
}
table.tasks{
	margin:0;
	padding:0 0 2px;
}

p.task_inforight{
 /*float: left;*/
}

#group_tasks_widget {
	margin:0 0 20px 0;
	padding: 0 0 5px 0;
	background:white;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
}
#group_tasks_widget .search_listing {
	border: 2px solid #cccccc;
}

.tasks label {display: inline-block; width: 120px}


#task-calendar-script-warning {
	display: none;
	background: #eee;
	border-bottom: 1px solid #ddd;
	padding: 0 10px;
	line-height: 40px;
	text-align: center;
	font-weight: bold;
	font-size: 12px;
	color: red;
}

#task-calendar-loading {
	display: none;
	position: absolute;
	top: 10px;
	right: 10px;
}

#task-calendar {
	margin: 5px;
}