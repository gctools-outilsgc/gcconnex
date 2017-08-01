<?php
$lang = (string) get_input('lang');
$source = 'embed';

if(!$lang){
  $lang = get_current_language();
  $source = 'base';
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

 <h2 class="mrgn-lft-sm"><?php echo elgg_echo('freshdesk:ticket:title', array(), $lang); ?></h2>
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

$(document).ready(function(){

  //validate form
  $('#sendTicket').on('click', function(e){
    e.preventDefault();

    var form = $('.elgg-form-ticket');

    var description = form.find('textarea');

    //handle adding error labels amd classes on textarea
    if($.trim($(description).val()) == '' && $(description).hasClass('error') != true){
      $(description).addClass('error').parent().append('<label id="description-error" for="cke_'+$(description).attr('name')+'" class="error">'+'<?php echo elgg_echo('freshdesk:valid', array(), $lang) ?>'+'</label>');
      $('#cke_'+$(description).attr('id')).attr('aria-labelledby', $(description).attr('id')+'-error');
    } else if($.trim($(description).val()) != ''){
      $(description).removeClass('error');
      $('#description-error').remove();
    }

    var inputs = form.find('input');

    //loop through the input fields
    inputs.each(function(){
      if($(this).attr('name') == 'email' || $(this).attr('name') == 'subject'){
        if($.trim($(this).val()) == '' && $(this).hasClass('error') != true){
          $(this).addClass('error').parent().append('<label for="'+$(this).attr('name')+'" class="error">'+'<?php echo elgg_echo('freshdesk:valid', array(), $lang) ?>'+'</label>');
        }
      }
    });

    var errors = form.find('.error:visible');

    //handle focusing on top error
    if(errors.length > 0){
      if(errors.first().is('input')){
        errors.first().focus();
      } else {
        CKEDITOR.instances['description'].focus();
      }
    } else {
      //disable submit button to avoid clicking button twice
      form.find('button').prop('disabled', true);
      //submit ticket
      submitTicket(form, "<?php echo $lang;?>", "<?php echo $source;?>");
    }

  });
});


</script>
