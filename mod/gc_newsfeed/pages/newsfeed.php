<?php

/*
 *  Create news feed page using cstom_index_widgets index page
 */

elgg_set_context('custom_index_widgets');
elgg_set_page_owner_guid(elgg_get_config('site_guid'));

$widgettypes = elgg_get_widget_types();

$page_owner = elgg_get_page_owner_guid();
$ciw_layout = elgg_get_plugin_setting("ciw_layout", "custom_index_widgets");
$ciw_showdashboard = elgg_get_plugin_setting("ciw_showdashboard", "custom_index_widgets");

$customwidgets = elgg_get_widgets($page_owner, elgg_get_context());
$area1widgets = isset($customwidgets[1]) ? $customwidgets[1] : FALSE;
$area2widgets = isset($customwidgets[2]) ? $customwidgets[2] : FALSE;
$area3widgets = isset($customwidgets[3]) ? $customwidgets[3] : FALSE;
/*
$area1widgets = elgg_get_widgets($page_owner,elgg_get_context(),1);
$area2widgets = elgg_get_widgets($page_owner,elgg_get_context(),2);
$area3widgets = elgg_get_widgets($page_owner,elgg_get_context(),3);
 */

if (empty($area1widgets) && empty($area2widgets) && empty($area3widgets)) {

    if (isset($vars['area3'])) $vars['area1'] = $vars['area3'];
    if (isset($vars['area4'])) $vars['area2'] = $vars['area4'];
}

$leftcolumn_widgets_view = custom_index_build_columns($area1widgets,$widgettypes);
$middlecolumn_widgets_view = custom_index_build_columns($area2widgets,$widgettypes);
$rightcolumn_widgets_view = custom_index_build_columns($area3widgets,$widgettypes);

$content =  elgg_view_layout($ciw_layout, array('area1' => $leftcolumn_widgets_view,'area2' => $middlecolumn_widgets_view,'area3' => $rightcolumn_widgets_view, 'layoutmode' => 'index_mode') );

if (elgg_is_logged_in() && $ciw_showdashboard=="yes"){

    $user_guid = elgg_get_logged_in_user_guid();
    elgg_set_page_owner_guid($user_guid);
    elgg_set_context('dashboard');


    $dashboardwidgets = elgg_get_widgets($user_guid, elgg_get_context());
    $area1widgets = isset($dashboardwidgets[1]) ? $dashboardwidgets[1] : FALSE;
    $area2widgets = isset($dashboardwidgets[2]) ? $dashboardwidgets[2] : FALSE;
    $area3widgets = isset($dashboardwidgets[3]) ? $dashboardwidgets[3] : FALSE;
    /*
    $area1widgets = elgg_get_widgets($user_guid,elgg_get_context(),1);
    $area2widgets = elgg_get_widgets($user_guid,elgg_get_context(),2);
    $area3widgets = elgg_get_widgets($user_guid,elgg_get_context(),3);
     */
    if (empty($area1widgets) && empty($area2widgets) && empty($area3widgets)) {

        if (isset($vars['area3'])) $vars['area1'] = $vars['area3'];
        if (isset($vars['area4'])) $vars['area2'] = $vars['area4'];

    }

    $leftcolumn_widgets_view = custom_index_build_columns($area1widgets,$widgettypes);
    $middlecolumn_widgets_view = custom_index_build_columns($area2widgets,$widgettypes);
    $rightcolumn_widgets_view = custom_index_build_columns($area3widgets,$widgettypes);

    $content  .= elgg_view_layout($ciw_layout, array('area1' => $leftcolumn_widgets_view,'area2' => $middlecolumn_widgets_view,'area3' => $rightcolumn_widgets_view, 'layoutmode' => 'index_mode') );
}

//EW - Department verification
if(elgg_is_logged_in()){

    //load int value
    $timestamp = is_array(elgg_get_logged_in_user_entity()->last_department_verify) ? elgg_get_logged_in_user_entity()->last_department_verify[0] : elgg_get_logged_in_user_entity()->last_department_verify;

    if((time() - $timestamp) > 15552000)
    {
        //create hidden link
        $content .= elgg_view('output/url', array(
            'href' => 'ajax/view/verify_department/verify_department',
            'text' => 'verify',
            'id' => 'verify',
            'aria-hidden' => 'true',
            'class' => 'elgg-lightbox hidden',
        ));

        //after page is loaded click link
        $content .= '<script> window.onload = function () { document.getElementById("verify").click() } </script>';
    }
}


echo elgg_view_page( elgg_echo('newsfeed:menu'), $content . $onboard);
