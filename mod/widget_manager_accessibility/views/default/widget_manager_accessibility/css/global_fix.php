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