<?php

$graphics_folder = $vars['url'] . 'mod/file_tools/_graphics/';

?>

#file_tools_edit_form_access_extra label {
	font-size: 100%;
    font-weight: normal;
}

#file_tools_list_folder p
{
	margin: 0px;
}

#file_tools_list_folder_actions,
.file_tools_folder_actions,
.file_tools_file_actions {
	float: right;
} 

.file_tools_folder_actions
{
	margin-right: 10px;
}

.file_tools_folder_title,
.file_tools_folder_etc,
.file_tools_file_title,
.file_tools_file_etc
{
	float: left;
	width: 200px;
}

.file_tools_file_etc
{
	width: 225px;
}

.file_tools_file_etc span
{
	float: right;
	width: 60px;
}

.file_tools_file_icon,
.file_tools_folder_icon
{
	float: left;
	width: 24px;
	height: 24px;
	margin-right: 10px;
}

#file_tools_list_tree_container {	
	overflow: auto;
}

#file_tools_list_tree_info {
	color: grey;
}

#file_tools_list_tree_info > div {
	background: url(<?php echo $vars["url"]; ?>_graphics/icon_customise_info.gif) top left no-repeat;
	padding-left: 16px; 
	color: #333333;
	font-weight: bold;
}

/* loading overlay */

#file_tools_list_files {
	position: relative;
	
}

#file_tools_list_files_overlay {
	display: none;
	background: white;
	height: 100%;
	position: absolute;
	opacity: 0.6;
	filter: alpha(opacity=60);
	z-index: 100;
	background: url("<?php echo $vars["url"]; ?>_graphics/ajax_loader.gif") no-repeat scroll center center white;
	padding: auto;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}

/* breadcrumb */
#file_tools_breadcrumbs_file_title {
	float: right;
}

#file_tools_breadcrumbs ul{
	border: 1px solid #DEDEDE;
    height: 2.3em;
}

#file_tools_breadcrumbs ul,
#file_tools_breadcrumbs li {
	list-style-type:none;
	padding:0;
	margin:0
}

#file_tools_breadcrumbs li {
	float:left;
	line-height:2.3em;
	padding-left:.75em;
	color:#777;
	min-width: 50px;
}
#file_tools_breadcrumbs li a {
	display:block;
	padding:0 15px 0 0;
	background:url(<?php echo $vars["url"]; ?>mod/file_tools/_graphics/crumbs.gif) no-repeat right center;
}

#file_tools_breadcrumbs li a:link, 
#file_tools_breadcrumbs li a:visited {
	text-decoration:none;
   	color:#777;
}

#file_tools_breadcrumbs li a:hover,
#file_tools_breadcrumbs li a:focus {
	color:#333;
}


/* extending file tree classic theme */

#file_tools_list_tree.tree li {
	line-height: 20px;
}
 
#file_tools_list_tree.tree li span {
	padding: 1px 0px;
}

#file_tools_list_tree.tree-classic li a {
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border: 1px solid transparent;	
}

#file_tools_list_tree.tree-classic li a:hover {
	border: 1px solid #CCCCCC;
}

#file_tools_list_tree.tree-classic li a.clicked {
	background: #DEDEDE;
    border: 1px solid #CCCCCC;
    color: #999999;
}

#file_tools_list_tree.tree-classic li a.clicked:hover {
	background: #CCCCCC;
    border: 1px solid #CCCCCC;
    color: white;
}

#file_tools_list_tree.tree-classic li a.ui-state-hover{
	background: #0054A7;
	border: 1px solid #0054A7;	
	color: white;
}

/* **************************
File tree widget
**************************** */
.file_tools_widget_edit_folder_wrapper ul {
	list-style: none outside none;
	margin: 0;
	padding: 0;
}

.file_tools_widget_edit_folder_wrapper ul ul {
	padding-left: 10px;
}

.file_tools_widget_edit_folder_wrapper li {

}

.file_tools_folder, .file_tools_file
{
	position: relative;
	height: 25px;
	line-height: 25px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background-color: #ffffff;
	margin: 0 10px 5px;
	padding-left: 5px;
    /*padding-right: 10px;*/
    padding-top: 2px;
}

.file_tools_folder img, .file_tools_file img
{
	margin-right: 10px;
	width: 24px;
	height: 24px;
}

#file_tools_list_files_sort_options span
{
	color: #333333;
    font-weight: bold;
}

#file_tools_folder_preview
{
	margin-top: 20px;
}

.progressWrapper {
	width: 357px;
	overflow: hidden;
}

.progressContainer {
	margin: 5px;
	padding: 4px;
	border: solid 1px #E8E8E8;
	background-color: #F7F7F7;
	overflow: hidden;
}
/* Message */
.message {
	margin: 1em 0;
	padding: 10px 20px;
	border: solid 1px #FFDD99;
	background-color: #FFFFCC;
	overflow: hidden;
}
/* Error */
.red {
	border: solid 1px #B50000;
	background-color: #FFEBEB;
}

/* Current */
.green {
	border: solid 1px #DDF0DD;
	background-color: #EBFFEB;
}

/* Complete */
.blue {
	border: solid 1px #CEE2F2;
	background-color: #F0F5FF;
}

.progressName {
	font-size: 8pt;
	font-weight: 700;
	color: #555;
	width: 323px;
	height: 14px;
	text-align: left;
	white-space: nowrap;
	overflow: hidden;
}

.progressBarInProgress,
.progressBarComplete,
.progressBarError {
	font-size: 0;
	width: 0%;
	height: 2px;
	background-color: blue;
	margin-top: 2px;
}

.progressBarComplete {
	width: 100%;
	background-color: green;
	visibility: hidden;
}

.progressBarError {
	width: 100%;
	background-color: red;
	visibility: hidden;
}

.progressBarStatus {
	margin-top: 2px;
	width: 337px;
	font-size: 7pt;
	font-family: Arial;
	text-align: left;
	white-space: nowrap;
}

a.progressCancel {
	font-size: 0;
	display: block;
	height: 14px;
	width: 14px;
	background-image: url(<?php echo $vars["url"]; ?>mod/file_tools/_graphics/swfupload/cancelbutton.gif);
	background-repeat: no-repeat;
	background-position: -14px 0px;
	float: right;
}

a.progressCancel:hover {
	background-position: 0px 0px;
}

#file_tools_list_new_file,
#file_tools_list_new_folder,
#file_tools_list_new_zip
{
	display: none;
}

.file_tools_file_actions, .file_tools_folder_actions
{
	position: relative;
}

input[name="file_tools_file_action_check"]
{
	margin: 5px 10px 0 15px;	
}

.file_tools_file_actions span,
.file_tools_folder_actions span
{
    cursor: pointer;
    display: block;
    position: absolute;
    right: 22px;
    width: 50px;
    z-index: 9;
	background: url(<?php echo $graphics_folder; ?>arrows_down.png) right center no-repeat;
	padding: 0px 17px 0px 5px;
}

.file_tools_file_actions ul,
.file_tools_folder_actions ul
{
    display: none;
    background-color: #ffffff;
    border: 1px #CCCCCC solid;
    padding: 0px 15px 0px 10px;
	min-width: 46px;
	cursor: default;
}

.file_tools_file_actions ul li a,
.file_tools_folder_actions ul li a
{
	white-space: nowrap;
}

.file_tools_file_actions:hover span,
.file_tools_folder_actions:hover span
{
	background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    border-bottom: 0px;
    line-height: 23px;
    width: 49px;
}

.file_tools_file_actions:hover ul,
.file_tools_folder_actions:hover ul {
    display: block;
    position: absolute;
    right: 22px;
    top: 18px;
    z-index: 8;
    list-style: none;
}

.file_tools_file_actions:hover,
.file_tools_folder_actions:hover
{
	z-index: 10;
	
	zoom: 1; /* IE hack */
}

#file_tools_file_upload_form .flash_wrapper {
	background: #4690D6;
	display: inline;
    margin: 10px;
    padding: 0px 6px;
    float: left;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
}
#file_tools_file_upload_form .flash_wrapper:hover {
	background: #0054A7;
}	

/* fixes layout in widget */
.collapsable_box  #filerepo_widget_layout {
	margin: 0px;
}
.filerepo_widget_singleitem_more{
	margin: 0 10px;
}
.file_tools_file.ui-draggable {
	border: 1px solid #CCC;
}