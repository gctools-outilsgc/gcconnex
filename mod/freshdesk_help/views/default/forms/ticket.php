<?php
$lang = (string) get_input('lang');
$source = 'embed';
$product_id  = (int) elgg_get_plugin_setting("embed_product_id", "freshdesk_help");

if(!$lang){
  $lang = get_current_language();
  $source = 'base';
  $product_id  = (int) elgg_get_plugin_setting("product_id", "freshdesk_help");
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
  $type = $sticky_values['type'];

  elgg_clear_sticky_form('ticket-submit');
}
 ?>


<div class="panel-body">
<h2><?php echo elgg_echo('freshdesk:ticket:title', array(), $lang); ?></h2>
<div class="mrgn-tp-sm">
  <p><?php echo elgg_echo('freshdesk:ticket:information', array(), $lang); ?></p>
  <p><?php echo elgg_echo('freshdesk:ticket:information:note', array(), $lang); ?></p>
</div>

<div class="mrgn-tp-md">
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
<label for="type"><?php echo elgg_echo('freshdesk:ticket:type', array(), $lang); ?></label>
<?php echo elgg_view('input/select', array(
  'name' => 'type',
  'id' => 'type',
  'required' => 'required',
  'value' => $type,
  'options_values' => [
		'None' => elgg_echo('freshdesk:ticket:types:none', array(), $lang),
		'Log in credentials' => elgg_echo('freshdesk:ticket:types:login', array(), $lang),
    'Bugs/Errors' => elgg_echo('freshdesk:ticket:types:bugs', array(), $lang),
    'Group-related' => elgg_echo('freshdesk:ticket:types:group', array(), $lang),
    'Training' => elgg_echo('freshdesk:ticket:types:training', array(), $lang),
    'Jobs Marketplace' => elgg_echo('freshdesk:ticket:types:jobs', array(), $lang),
    'Enhancement' => elgg_echo('freshdesk:ticket:types:enhancement', array(), $lang),
    'Flag content or behaviour' => elgg_echo('freshdesk:ticket:types:flag', array(), $lang),
    'Other' => elgg_echo('freshdesk:ticket:types:other', array(), $lang),
	],
));
?>
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

    if($('#type option:selected').val() == 'None' && $('#type').hasClass('error') != true){
      $('#type').addClass('error').parent().append('<label for="'+$('#type').attr('name')+'" class="error">'+'<?php echo elgg_echo('freshdesk:valid', array(), $lang) ?>'+'</label>');
    }

    var inputs = form.find('input');

    //loop through the input fields
    inputs.each(function(){
      if($(this).attr('name') == 'email' || $(this).attr('name') == 'subject'){
        if($.trim($(this).val()) == '' && $(this).hasClass('error') != true){
          $(this).addClass('error').parent().append('<label for="'+$(this).attr('name')+'" class="error">'+'<?php echo elgg_echo('freshdesk:valid', array(), $lang) ?>'+'</label>');
        }
      } else if($(this).attr('name') == 'attachment'){
        if($(this).val() != '' && $(this).hasClass('error') != true){
          var ext = $('#attachment').val().split('.').pop().toLowerCase();
          if($.inArray(ext, ['gif','png','jpg','jpeg','txt']) == -1) {
            $(this).addClass('error').parent().append('<label for="'+$(this).attr('name')+'" class="error">'+'<?php echo elgg_echo('freshdesk:valid:filetypes', array(), $lang) ?>'+'</label>');
          }
        }
      }
    });

    var errors = form.find('.error:visible');

    //handle focusing on top error
    if(errors.length > 0){
      if(errors.first().is('input') || errors.first().is('select')){
        errors.first().focus();
      } else {
        CKEDITOR.instances['description'].focus();
      }
    } else {
      //disable submit button to avoid clicking button twice
      form.find('button').prop('disabled', true);
      //submit ticket
      submitTicket(form, "<?php echo $lang;?>", "<?php echo $source;?>", <?php echo $product_id; ?>);
    }

  });
});


</script>
