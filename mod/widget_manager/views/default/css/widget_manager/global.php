<?php
?>
/* lightbox */
#widget_manager_widgets_select {
	margin: 0;
}

#widget_manager_widgets_select .widget_manager_widgets_lightbox_wrapper {
	margin-bottom: 5px;
	border: 1px solid transparent;
}

#widget_manager_widgets_select .widget_manager_widgets_lightbox_wrapper:hover {
	border: 1px solid #CCCCCC;
}

#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions {
	float: right;
	padding: 6px;
}

#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-available span,
#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-unavailable input {
	display: none;
}

#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions .submit_button {
	margin: 5px 0;
}

#widget_manager_widgets_search {
	float: right;
    margin-top: -2px;
}

#widget_manager_widgets_search input {
	padding: 0;
	margin: 0;
	font-size: 100%;
	height: 100%;
}

.elgg-module-widget .elgg-menu-widget .elgg-menu-item-settings,
.elgg-module-widget .elgg-menu-widget .elgg-menu-item-delete {
	display: none;
}
.elgg-module-widget:hover .elgg-menu-widget .elgg-menu-item-settings,
.elgg-module-widget:hover .elgg-menu-widget .elgg-menu-item-delete {
	display: inline-block;
}