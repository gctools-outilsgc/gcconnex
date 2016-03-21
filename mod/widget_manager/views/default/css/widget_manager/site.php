<?php
?>
.widget_manager_hide_header > .elgg-head,
.widget_manager_hide_header_admin > .elgg-head {
	display: none;
}

.widget_manager_hide_header_admin:hover > .elgg-head {
	display: block;
}

.widget_manager_hide_header_admin:hover > .elgg-body {
	border-top-width: 2px;
}

.elgg-module-widget.widget_manager_disable_widget_content_style > .elgg-body,
.widget_manager_hide_header_admin > .elgg-body,
.widget_manager_hide_header > .elgg-body {
	border-top-width: 0px;
}

.elgg-module-widget.widget_manager_disable_widget_content_style {
	background: none;
	padding: 0px;
}

.elgg-module-widget.widget_manager_disable_widget_content_style .elgg-widget-content {
	padding: 0px;
}

.elgg-module-widget.widget_manager_disable_widget_content_style > .elgg-head {
	border: 2px solid #DEDEDE;
}

#widget-manager-multi-dashboard {
	background: #CCC;
}

#widget-manager-multi-dashboard-tabs {
	position: absolute;
	top: 20px;
}

.widget-manager-multi-dashboard-tabs-edit {
	display: none;
	vertical-align: middle;
}

.widget-manager-multi-dashboard-tab:hover > a {
	padding-right: 5px;
}

.widget-manager-multi-dashboard-tab:hover .widget-manager-multi-dashboard-tabs-edit {
	display: inline-block;
	margin-left: 5px;
}

#widget-manager-multi-dashboard-tabs .widget-manager-multi-dashboard-tab-active {
	border-color: #666666;
}
#widget-manager-multi-dashboard-tabs .widget-manager-multi-dashboard-tab-hover {
	border-color: #333333;
}

.widget-manager-groups-widgets-top-row {
	width: 100%;
	min-height: 0px !important;
}

.widget-manager-groups-widgets-top-row-highlight {
	min-height: 50px !important;
}

.widget-manager-widget-access .elgg-text-help {
	display: none;
}