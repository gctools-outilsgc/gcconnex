<?php
$lang = (string) get_input('lang');

if(!$lang){
  $lang = get_current_language();
}
//populate form with known information
if(elgg_is_logged_in()){
  $email = elgg_get_logged_in_user_entity()->email;
}

//populate form if submission encountered an error
if (elgg_is_sticky_form('ticket-submit')) {
  $sticky_values = elgg_get_sticky_values('ticket-submit');

  $email = $sticky_values['email'];
  $description = $sticky_values['description'];
  $subject = $sticky_values['subject'];

  elgg_clear_sticky_form('ticket-submit');
}
 ?>

 <h3 class="h2 mrgn-lft-sm"><?php echo elgg_echo('freshdesk:ticket:title', array(), $lang); ?></h3>
<div class="panel-body">

<div>
<label for="email"><?php echo elgg_echo('freshdesk:ticket:email', array(), $lang); ?></label>
<?php echo elgg_view('input/text', array(
  'name' => 'email',
  'id' => 'email',
  'value' => $email,
  'class' => 'mrgn-bttm-sm',
  'required' => 'required'
));
?>
</div>

<div>
<label for="subject"><?php echo elgg_echo('freshdesk:ticket:subject', array(), $lang); ?></label>
<?php echo elgg_view('input/text', array(
  'name' => 'subject',
  'id' => 'subject',
  'required' => 'required',
  'value' => $subject,
  'onkeyup' => 'matchArticles(this, "'.$lang.'")'
));
?>
<span class="relatedArticles btn-primary"><a href="#searchResults"></a></span>
</div>

<div>
<label for="attachment"><?php echo elgg_echo('freshdesk:ticket:attachment', array(), $lang); ?></label>
<?php echo elgg_view('input/file', array('name' => 'attachment', 'id' => 'attachment', 'class' => 'mrgn-bttm-sm')); ?>
</div>

<div>
<label for="description"><?php echo elgg_echo('freshdesk:ticket:description', array(), $lang); ?></label>
<?php echo elgg_view('input/longtext', array(
  'name' => 'description',
  'id' => 'description',
  'class' => 'mrgn-bttm-sm validate-me',
  'required' => 'required',
  'value' => $description
));
?>
</div>
<?php echo elgg_view('input/hidden', array('name' => 'lang', 'value' => $lang)); ?>
<?php echo elgg_view('input/submit', array('value' => elgg_echo('submit', array(), $lang), 'id' => 'sendTicket', 'class' => 'btn-primary btn-lg mrgn-tp-md'));?>
</div>

<script>

$('.relatedArticles a').on('click', function(){
  $('.nav-tabs').find('a').first().trigger('click');

  $('#article-search').val($('#subject').val()).trigger('keyup');
});
</script>
