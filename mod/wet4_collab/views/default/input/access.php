<script>
$(document).ready(function () {

    $('#dialog-modal').dialog({
        modal: true,
        autoOpen: false
    });

    $('select[name=access_id]').change(function () {
        if ($(this).val() != "2") {
            $('#myModal').modal('show');
        }
    });

});

</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo elgg_echo('msg:change_access_title'); ?><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></h3>

  </div>
  <div class="panel-body">
    <?php echo elgg_echo("msg:change_access"); ?>  
    </div>
</div>
  </div>
</div>
<?php


/**
 * Elgg access level input
 * Displays a dropdown input field
 *
 * @uses $vars['value']                  The current value, if any
 * @uses $vars['options_values']         Array of value => label pairs (overrides default)
 * @uses $vars['name']                   The name of the input field
 * @uses $vars['entity']                 Optional. The entity for this access control (uses access_id)
 * @uses $vars['class']                  Additional CSS class
 *
 * @uses $vars['entity_type']            Optional. Type of the entity
 * @uses $vars['entity_subtype']         Optional. Subtype of the entity
 * @uses $vars['container_guid']         Optional. Container GUID of the entity
 * @usee $vars['entity_allows_comments'] Optional. (bool) whether the entity uses comments - used for UI display of access change warnings
 *
 *
 * GC_MODIFICATION
 * Description: Added modal that will pop up inviting the user to make their content open
 * Author: GCTools Team
 */


// bail if set to a unusable value
if (isset($vars['options_values'])) {
	if (!is_array($vars['options_values']) || empty($vars['options_values'])) {

		return;
	}
}



$entity_allows_comments = elgg_extract('entity_allows_comments', $vars, true);
unset($vars['entity_allows_comments']);

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-access';

// this will be passed to plugin hooks ['access:collections:write', 'user'] and ['default', 'access']
$params = array();

$keys = array(
	'entity' => null,
	'entity_type' => null,
	'entity_subtype' => null,
	'container_guid' => null,
	'purpose' => 'read',
);
foreach ($keys as $key => $default_value) {
	$params[$key] = elgg_extract($key, $vars, $default_value);
	unset($vars[$key]);
}

/* @var ElggEntity $entity */
$entity = $params['entity'];

if ($entity) {
	$params['value'] = $entity->access_id;
	$params['entity_type'] = $entity->type;
	$params['entity_subtype'] = $entity->getSubtype();
	$params['container_guid'] = $entity->container_guid;

	if ($entity_allows_comments && ($entity->access_id != ACCESS_PUBLIC)) {
		$vars['data-comment-count'] = (int) $entity->countComments();
		$vars['data-original-value'] = $entity->access_id;
	}
}

$container = elgg_get_page_owner_entity();
if (!$params['container_guid'] && $container) {
	$params['container_guid'] = $container->guid;
}

// don't call get_default_access() unless we need it
if (!isset($vars['value']) || $vars['value'] == ACCESS_DEFAULT) {
	if ($entity) {
		$vars['value'] = $entity->access_id;
	} else if (empty($vars['options_values']) || !is_array($vars['options_values'])) {
		$vars['value'] = get_default_access(null, $params);
	} else {
		$options_values_ids = array_keys($vars['options_values']);
		$vars['value'] = $options_values_ids[0];
	}
}

$params['value'] = $vars['value'];

// don't call get_write_access_array() unless we need it
if (!isset($vars['options_values'])) {
	$vars['options_values'] = get_write_access_array(0, 0, false, $params);
	 // unset($vars['options_values'][1]); //remove ACCESS_LOGGED_IN

}

if (!isset($vars['disabled'])) {
	$vars['disabled'] = false;


}

// if access is set to a value not present in the available options, add the option
if (!isset($vars['options_values'][$vars['value']])) {

	$acl = get_access_collection($vars['value']);
	$display = $acl ? $acl->name : elgg_echo('access:missing_name');

	$vars['options_values'][$vars['value']] = $display;

	
}

// should we tell users that public/logged-in access levels will be ignored?
if (($container instanceof ElggGroup)
	&& $container->getContentAccessMode() === ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY
	&& !elgg_in_context('group-edit')
	&& !($entity instanceof ElggGroup)) {

	$show_override_notice = true;
} else {
	$show_override_notice = false;

}

if ($show_override_notice) {
	$vars['data-group-acl'] = $container->group_acl;

}

//EW - Made the default access for closed group content set to group not private
if(!$entity && ($container instanceof ElggGroup)){
    if($container->getContentAccessMode() == ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED){
        $vars['value'] = elgg_get_config('default_access');
    } else {
        $vars['value'] = $container->group_acl;
    }
} else if( $vars['value'] == ACCESS_DEFAULT || $vars['value'] == ACCESS_PUBLIC ){
	// MW - Fall back on default_access if value is set to ACCESS_DEFAULT or ACCESS_PUBLIC
	$vars['value'] = elgg_get_config('default_access');
}

if( $params['value'] ){
	$vars['value'] = $params['value'];
}

echo elgg_view('input/select', $vars);
if ($show_override_notice) {
	echo elgg_format_element('p', ['class' => 'elgg-text-help'], elgg_echo('access:overridenotice'));
}



