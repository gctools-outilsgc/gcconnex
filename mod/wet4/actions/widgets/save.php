<?php
/**
 * GCconnex save widget settings action. Added support to two languages entry
 *
 * @package Elgg.Core
 * @subpackage Widgets.Management
 *
 * @uses int    $_REQUEST['guid']            The guid of the widget to save
 * @uses array  $_REQUEST['params']          An array of params to set on the widget.
 * @uses int    $_REQUEST['default_widgets'] Flag for if these settings are for default wigets.
 * @uses string $_REQUEST['context']         An optional context of the widget. Used to return
 *                                           the correct output if widget content changes
 *                                           depending on context.
 * @uses string $_REQUEST['title']           Optional title for the widget
 * @uses bool $_REQUEST['two_lang']          Optional.  If set then we will save both languages together and look for 2 title and 2 html content
 */

if(isset($_REQUEST['two_lang'])){

}
else
{
    $guid = get_input('guid');
    $params = get_input('params');
    $default_widgets = get_input('default_widgets', 0);
    $context = get_input('context');
    $title = get_input('title');

    if ($default_widgets) {
        elgg_push_context('default_widgets');
    }
    elgg_push_context('widgets');

    $widget = get_entity($guid);
    if ($widget && $widget->saveSettings($params)) {
        if ($title && $title != $widget->title) {
            $widget->title = $title;
            $widget->save();
        }

        elgg_set_page_owner_guid($widget->getContainerGUID());
        if ($context) {
            elgg_push_context($context);
        }
        
        echo elgg_view('object/widget/elements/content', ['entity' => $widget]);
        
        if ($context) {
            elgg_pop_context();
        }
        
    } else {
        register_error(elgg_echo('widgets:save:failure'));
    }
}
// widgets context
elgg_pop_context();

if ($default_widgets) {
    elgg_pop_context();
    }

forward(REFERER);