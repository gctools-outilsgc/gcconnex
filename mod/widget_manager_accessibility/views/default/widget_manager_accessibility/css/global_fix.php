<?php ?>

#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-available span ,
#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-available input ,
#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-unavailable input {
    width: 140px;
}

/**/
#widget_manager_widgets_select > .elgg-body {
    background-color: white;
}

#widget_manager_widgets_select > .elgg-head {
    position: fixed;
    width: 575px;
    z-index: 1;
}


#widget_manager_widgets_select {
 overflow-y: scroll;
 height: inherit;
}

#widget_manager_widgets_select > .elgg-head {
    position: fixed;
    /*width: inherit;*/
    z-index: 1;
    padding: 0px;
    background: none;
}
#widget_manager_widgets_select > .elgg-head > h3 {
    padding: 5px;
    background: #F1F1F1;
    margin-right: 15px;
}

#widget_manager_widgets_select > .elgg-body {
    background-color: white;
    padding-top: 60px;
}

.elgg-module-inline > .elgg-head h3 {
    color: black;
}


/* bootstrap overrides */

.btn-primary,
.btn-primary:hover {
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}

.btn-primary.active {
    color: rgba(255, 255, 255, 0.75);
}

.multi-widget-count {
    float: right;
    padding: 5px;
    height: 0.75em;
    width: 15px;
    margin: 11px -11px 0px 6px;
    border-radius: 5px;
    line-height: 0.75em;
    text-shadow: 1px 1px gray;
    color: white;
}

.multi-widget-count-activated {
    -webkit-box-shadow: 3px 3px 2px -2px black;
    box-shadow: 3px 3px 2px -2px black;
    background-color: lightgray;
}

.widget-added.btn-primary {
    background-color: #FF3232;
    background-image: -moz-linear-gradient(center top , #b20000, #e50000);
    *background-color: #e50000;
    background-image: -ms-linear-gradient(top, #b20000, #e50000);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b20000), to(#e50000));
    background-image: -webkit-linear-gradient(top, #b20000, #e50000);
    background-image: -o-linear-gradient(top, #b20000, #e50000);
    background-image: -moz-linear-gradient(top, #b20000, #e500000);
    background-image: linear-gradient(top, #b20000, #e50000);
    background-repeat: repeat-x;
    border-color: #e50000 #e50000 #458B00;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    filter: progid:dximagetransform.microsoft.gradient(startColorstr='#b20000', endColorstr='#e50000', GradientType=0);
    filter: progid:dximagetransform.microsoft.gradient(enabled=false);
}

.widget-added.btn-primary:hover,
.widget-added.btn-primary:active,
.widget-added.btn-primary.active,
.widget-added.btn-primary.disabled,
.widget-added.btn-primary[disabled] {
    background-color: #e50000;
    *background-color: #458B00;
}


.btn-primary:active,
.btn-primary.active {
    background-color: #458B00 \9;
}


/* end of bootstrap overrides */



/* lightbox */
#widget_manager_widgets_select {
    margin: 0;
    width: inherit;
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

#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li {
    list-style: none;
}

#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-available span ,
#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-unavailable input {
    list-style: none;
}

#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-available input.btn.elgg-button.elgg-button-submit.widget-added {
    display: none;
}

#widget_manager_widgets_select .widget_manager_widgets_lightbox_actions li.elgg-state-unavailable input.btn.elgg-button.elgg-button-submit.widget-to-add {
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

.elgg-module-widget a.widget-manager-widget-title-link {
    width: auto;
}

.widget_manager_hide_header_admin > .elgg-head {
    opacity: 0.6;
    filter: alpha(opacity=60);
}

#widget_manager_widgets_select > .elgg-head {
    position: fixed;
    width: inherit;
    z-index: 1;
    padding: 0px;
    background: none;
}

#widget_manager_widgets_select > .elgg-head > h3 {
    padding: 5px;
    background: #F1F1F1;
    margin-right: 15px;
}

#widget_manager_widgets_select > .elgg-body {
    background-color: white;
    padding-top: 40px;
}

.elgg-module-inline > .elgg-head h3 {
    color: black;
}

.elgg-module-widget.widget_manager_disable_widget_content_style > .elgg-body,
.widget_manager_hide_header > .elgg-body {
    border-top: 0px;
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

.elgg-menu-widget .elgg-menu-item-fix {
    right: 45px;
}

.elgg-icon-widget-manager-push-pin {
    background: url("<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png") no-repeat scroll 0px -738px transparent;
}

.widget-manager-fix.fixed > .elgg-icon-widget-manager-push-pin {
    background-position: 0px -720px;
}

#widget-manager-multi-dashboard {
    background: #CCC;
}

#widget-manager-multi-dashboard-tabs {
    position: absolute;
    top: 8px;
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