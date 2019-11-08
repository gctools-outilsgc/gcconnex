<?php
/**
 * List replies with optional add form
 *
 * @uses $vars['entity']        ElggEntity the group discission
 * @uses $vars['show_add_form'] Display add form or not
 */

if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false ) {
	
} else {

	$attr = [
		'id' => 'reply',
	];

	 $show_add_form = elgg_extract('show_add_form', $vars, true);

	 $replies = elgg_list_entities(array(
		 'type' => 'object',
		 'subtype' => 'discussion_reply',
		 'container_guid' => $vars['topic']->getGUID(),
		 'reverse_order_by' => true,
		 'distinct' => false,
		 'url_fragment' => 'group-replies',
		 'item_class' => 'panel',
	 ));

	 // check how many replies topic has
	 $num_replies = elgg_get_entities(array(
		 'type' => 'object',
		 'subtype' => 'discussion_reply',
		 'container_guid' => $vars['topic']->getGUID(),
		 'count' => true,
		 'distinct' => false,
	 ));


	 echo '<div id="group-replies" class="elgg-comments clearfix mrgn-tp-lg">';

	 // if topic has replies show replies header
	 if($num_replies != 0)
		 echo '<h2 class="panel-title mrgn-bttm-md">' . elgg_echo('group:replies') . '</h2>';
	 
	 echo $replies;

	 echo '</div>';

	 if ($show_add_form) {
		 $form_vars = array('class' => 'mtm clearfix');
		 $content .= elgg_view_form('discussion/reply/save', $form_vars, $vars);

		 echo elgg_format_element('div', $attr, $content);
	 }

 }

?>

<style>

    fieldset {
        padding: 0;
    }

</style>