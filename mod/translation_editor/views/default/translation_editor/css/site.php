<?php 
	$graphics_folder = $vars["url"] . "mod/translation_editor/_graphics/";
?>

#translation_editor_language_table th,
#translation_editor_plugin_list th {
	font-weight: bold;
}

#translation_editor_language_table .translation_editor_flag,
#translation_editor_language_table .translation_editor_enable {
	width: 1%;
	text-align: center;
}

#translation_editor_plugin_list th,
#translation_editor_plugin_list td {
	text-align: center;
	white-space: nowrap;
}

#translation_editor_plugin_list .first_col {
	text-align: left;
	width: 100%;
}

#translation_editor_site_language {
	color: gray;
	margin-left: 10px;
}

#translation_editor_custom_keys_translation_info {
	color: gray;
}

.translation_editor_translation_complete {
	color: green;
}

.translation_editor_translation_needed {
	color: red;
}

.translation_editor_translation_table textarea {	
	height: 70px;
}

.view_mode_active {
	font-weight: bold;
} 

.translation_editor_translation_table tr{
	display: none;
}

.translation_editor_translation_table tr.first_row th{
	font-weight: bold;
}

.translation_editor_translation_table tr.first_row th span{
	font-weight: normal;
}

.translation_editor_translation_table tr.first_row,
.translation_editor_translation_table tr[rel='missing']{
	display: table-row;
	<!-- 
	display: inline-block;
	-->
}

.translation_editor_plugin_key {
	float: right;
	width: 16px;
	height: 16px;
	background: url(<?php echo $graphics_folder;?>key.gif) no-repeat;
}

.translation_editor_translation_table {
	margin-bottom: 20px;
}
	
.translation_editor_translation_table pre {
	white-space: normal;
	margin-bottom: 5px;
}

.translation_editor_translation_table td{
	white-space: nowrap;
}

.translation_editor_translation_table .first_col {
	width: 33px;
}

#translation_editor_search_form td {
	width: 100%;
	white-space: nowrap;
}
