<?php
/**
 * Form for adding and editing comments
 *
 * @package Elgg
 *
 * @uses ElggEntity  $vars['entity']       The entity being commented
 * @uses ElggComment $vars['comment']      The comment being edited
 * @uses bool        $vars['inline']       Show a single line version of the form?
 * @uses bool        $vars['is_edit_page'] Is this form on its own page?
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels
 * Author: GCTools Team
 */
if (!elgg_is_logged_in()) {
	return;
}

// var for the modal
$entity = elgg_extract('entity', $vars);
$container = $entity->getContainerEntity();
$userentity = elgg_get_logged_in_user_entity();

$comment = elgg_extract('comment', $vars);
/* @var ElggComment $comment */

$inline = elgg_extract('inline', $vars, false);
$is_edit_page = elgg_extract('is_edit_page', $vars, false);

$entity_guid_input = '';
if ($entity) {
	$entity_guid_input = elgg_view('input/hidden', array(
		'name' => 'entity_guid',
		'value' => $entity->guid,
	));
}

$comment_text = '';
$comment_guid_input = '';
if ($comment && $comment->canEdit()) {
	$entity_guid_input = elgg_view('input/hidden', array(
		'name' => 'comment_guid',
		'value' => $comment->guid,
	));
	$comment_label  = elgg_echo("generic_comments:edit");
	$submit_input = elgg_view('input/submit', array('value' => elgg_echo('save')));
	$comment_text = $comment->description;
} else {
	$comment_label  = elgg_echo("generic_comments:add");

	if ((elgg_instanceof($container, 'group')) && (!$container->isMember($userentity))){
	
	$submit_input = elgg_view('input/button', array('value' => elgg_echo('comment'), 'class' => 'mrgn-tp-sm btn btn-primary', 'data-target' => "#notif_comment", 'data-toggle' => "modal"));

	}else{
	$submit_input = elgg_view('input/submit', array('value' => elgg_echo('comment'), 'class' => 'mrgn-tp-sm btn btn-primary', ));

	}
}

$cancel_button = '';
if ($comment) {
	$cancel_button = elgg_view('input/button', array(
		'value' => elgg_echo('cancel'),
		'class' => 'elgg-button-cancel mlm',
		'href' => $entity ? $entity->getURL() : '#',
	));
}

if ($inline) {
	$comment_input = elgg_view('input/text', array(
		'name' => 'generic_comment',
		'id' => 'generic_comment',
		'value' => $comment_text,
	));

	echo $comment_input . $entity_guid_input . $comment_guid_input . $submit_input;
} else {

	$comment_input = elgg_view('input/longtext', array(
		'name' => 'generic_comment',
		'value' => $comment_text,
		'id' => 'generic_comment',
	));

	$is_edit_page_input = elgg_view('input/hidden', array(
		'name' => 'is_edit_page',
		'value' => (int)$is_edit_page,
	));

	echo <<<FORM
<div>
	<label for="generic_comment">$comment_label</label>
	$comment_input
</div>
<div class="elgg-foot">
	$is_edit_page_input
	$comment_guid_input
	$entity_guid_input
	$submit_input $cancel_button
</div>
FORM;
}

?>
<script>
function join_comment() {

	document.getElementById('join').click();
	$('.elgg-system-messages').html("<?php echo elgg_echo('groups:joined'); ?>");
}

</script>

<!-- Modal -->
<div class="modal fade" id="notif_comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-content1">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <?php   
     echo '<h4 class="modal-title" id="myModalLabel">'.elgg_echo("comment_notif_title",array($container->getDisplayName())).'</h4>
      </div>
      <div class="modal-body">
     '.elgg_echo("comment_notif_description").'
      </div>
      <div class="modal-footer">';

      	

         $url = elgg_get_site_url() . "action/groups/join?group_guid={$container->getGUID()}";
              $url = elgg_add_action_tokens_to_url($url);
                  elgg_register_menu_item('modal_notif', array(
                        'name' => 'join',
                        'id' => 'join',
                        'href' => $url,
                        'text' => elgg_echo('join'),
                        'link_class' => 'elgg-button elgg-button-action',
                    ));

   $buttons = elgg_view_menu('modal_notif', array(
                            'sort_by' => 'priority',
                            'class' => 'hidden',
                        	'id' => 'join',
                            'item_class' => 'btn btn-primary',
                        ));

                        echo $buttons;

	if ( $container instanceof ElggGroup ){
     		if ($container->isPublicMembership() || $container->canEdit()) {
                        echo '<button class="mrgn-tp-sm btn btn-primary" onclick = "join_comment()">'.elgg_echo("groups:join").'</button>';
			
		} else {
			// request membership
                        echo '<button class="mrgn-tp-sm btn btn-primary" onclick = "join_comment()">'.elgg_echo("groups:joinrequest").'</button>';
			
		}
	}
	 				
	echo elgg_view('input/submit', array('value' => elgg_echo('comment'), 'id' => 'comment_test','class' => 'mrgn-tp-sm btn', ));
                         
      	?>
      
      </div>
    </div>
  </div>
</div>
