<?php
/*
* GC_MODIFICATION
* Description: Added accessible labels + content translation support
* Author: GCTools Team
*/
$poll = elgg_extract('entity', $vars);
if ($poll) {
	$guid = $poll->guid;
} else  {
	$guid = 0;
}

$lang = get_current_language();

$btn_language =  '<ul class="nav nav-tabs nav-tabs-language">
  <li id="btnen"><a href="#" id="btnClicken">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr"><a href="#" id="btnClickfr">'.elgg_echo('lang:french').'</a></li>
</ul>';


$question = $vars['fd']['question'];
$question2 = $vars['fd']['question2'];
$tags = $vars['fd']['tags'];
$access_id = $vars['fd']['access_id'];

$question_label = elgg_echo('polls:questionen');
$question_textbox = elgg_view('input/text', array('name' => 'question', 'id' => 'question', 'value' => $question));

$question_label2 = elgg_echo('polls:questionfr');
$question_textbox2 = elgg_view('input/text', array('name' => 'question2', 'id' => 'question2', 'value' => $question2));

$responses_label = elgg_echo('polls:responses');
$responses_control = elgg_view('polls/input/choices',array('poll'=>$poll, 'test' => $lang));

$tag_label = elgg_echo('tags');
$tag_input = elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags', 'value' => $tags));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array('name' => 'access_id', 'id' => 'access_id', 'value' => $access_id));

$submit_input = elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save')));
$submit_input .= ' '.elgg_view('input/button', array('name' => 'cancel', 'id' => 'polls_edit_cancel', 'type'=> 'button', 'value' => elgg_echo('cancel')));

if (isset($vars['entity'])) {
	$entity_hidden = elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
} else {
	$entity_hidden = '';
}

$entity_hidden .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));

echo <<<__HTML
$btn_language
<div class="tab-content tab-content-border">
<div class='en'>
		<p>
			<label for="question">$question_label</label><br />
			$question_textbox
		</p>
</div>
<div class='fr'>
		<p>
			<label for="question2">$question_label2</label><br />
			$question_textbox2
		</p>
		</div>
		<p>
			<label>$responses_label</label><br />
			$responses_control
		</p>

		<p >
			<label>$responses_label2</label><br />
			$responses_control2
		</p>


		<p>
			<label for="tags">$tag_label</label><br />
			$tag_input
		</p>
		<p>
			<label for="access_id">$access_label</label><br />
			$access_input
		</p>
		<p>
		$entity_hidden
		$submit_input
		</p>
</div>
__HTML;

		// TODO - move this JS
		?>
<div></div>
<script type="text/javascript">
$('#polls_edit_cancel').click(
	function() {
		window.location.href="<?php echo $vars['url'].'pg/polls/list/'.(elgg_get_page_owner_entity()->username); ?>";
	}
);
</script>

<?php

if(get_current_language() == 'fr'){
?>
	<script>
		jQuery('.fr').show();
	    jQuery('.en').hide();
	    jQuery('#btnfr').addClass('active');

	</script>
<?php
}else{
?>
	<script>
		jQuery('.en').show();
    	jQuery('.fr').hide();
    	jQuery('#btnen').addClass('active');
	</script>
<?php
}
?>
<script>
jQuery(function(){

	var selector = '.nav li';

	$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

		jQuery('#btnClickfr').click(function(){
               jQuery('.fr').show();
               jQuery('.en').hide();
        });

          jQuery('#btnClicken').click(function(){
               jQuery('.en').show();
               jQuery('.fr').hide();
        });
});
</script>
