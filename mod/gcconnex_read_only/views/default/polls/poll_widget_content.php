<?php
elgg_load_library('elgg:polls');

$poll = elgg_extract('entity', $vars);

if($msg = elgg_extract('msg', $vars)) {
	echo '<p>'.$msg.'</p>';
}

?>
<div id="poll-post-body-<?php echo $poll->guid; ?>" class="poll_post_body" style="display:block;">
<?php echo elgg_view('polls/results_for_widget', array('entity' => $poll)); ?>
</div>

