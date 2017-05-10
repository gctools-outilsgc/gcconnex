<?php
/**
 * comments.php
 * 
 * List comments with optional add form
 * 
 * @package wet4
 * @author GCTools Team
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 * @uses $vars['id']            Optional id for the div
 * @uses $vars['class']         Optional additional class for the div
 * @uses $vars['limit']         Optional limit value (default is 25)
 * 
 * @todo look into restructuring this so we are not calling elgg_list_entities()
 * in this view
 *
 */

$show_add_form = elgg_extract('show_add_form', $vars, true);
$full_view = elgg_extract('full_view', $vars, true);
$limit = elgg_extract('limit', $vars, get_input('limit', 0));
$page_owner = elgg_get_page_owner_entity();
if (!$limit) {
	$limit = elgg_trigger_plugin_hook('config', 'comments_per_page', [], 25);
}

$attr = [
	'id' => elgg_extract('id', $vars, 'comments'),
	'class' => (array) elgg_extract('class', $vars, []),
];
$attr['class'][] = 'elgg-comments testing';

// work around for deprecation code in elgg_view()
unset($vars['internalid']);

//check how many comments topic has
    $num_replies = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'comment',
        'container_guid' => $vars['entity']->guid,
        'count' => true,
        'distinct' => false,
    ));
    
        //Nick - keep the heading so users know comments are supposed to be here!
        //Nick Update - if this is in a group the comments will be an h3
        if($page_owner instanceof ElggGroup){
            echo '<h3 class="panel-title mrgn-bttm-md mrgn-tp-md h2">' . elgg_echo('comments') . '</h3>';
        }else{
            echo '<h2 class="panel-title mrgn-bttm-md mrgn-tp-md">' . elgg_echo('comments') . '</h2>';
        }
        
    
        if($num_replies == 0){
            echo '<div>'.elgg_echo('generic_comment:none').'</div>';
        }

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'comment',
	'container_guid' => $vars['entity']->guid,
	'reverse_order_by' => true,
	'full_view' => true,
	'limit' => $limit,
	'preload_owners' => true,
	'distinct' => false,
	'url_fragment' => $attr['id'],
));

if ($show_add_form)
	$content .= elgg_view_form('comment/save', array(), $vars);


echo elgg_format_element('div', $attr, $content);
