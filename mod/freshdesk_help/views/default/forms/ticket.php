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

<fieldset class="user-info">
  <legend><?php echo elgg_echo('freshdesk:ticket:legend:yourinfo', array(), $lang); ?></legend>
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

<?php echo elgg_view('input/path_based_input', array(
  'lang' => $lang,
  'product_id' => $product_id,
  'source' => $source
  )); ?>


<div id="desc-file-fields" class="hidden">
  <div class="mrgn-tp-sm">
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

  <div class="mrgn-tp-sm">
    <label for="attachment"><?php echo elgg_echo('freshdesk:ticket:attachment', array(), $lang); ?></label>
    <?php echo elgg_view('input/file', array('name' => 'attachment', 'id' => 'attachment', 'class' => 'mrgn-bttm-sm')); ?>
  </div>
</div>
</fieldset>

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
    if($.trim($(description).val()) == '' && $(description).hasClass('error') != true && !$('#desc-file-fields').hasClass("hidden")){
      $(description).addClass('error').parent().append('<label id="description-error" for="cke_'+$(description).attr('name')+'" class="error" onclick="focusCorrection()">'+'<?php echo elgg_echo('freshdesk:valid', array(), $lang) ?>'+'</label>');
      $('#cke_'+$(description).attr('id')).attr('aria-labelledby', $(description).attr('id')+'-error');
    } else if($.trim($(description).val()) != ''){
      $(description).removeClass('error');
      $('#description-error').remove();
    }

    var selects = form.find('select:visible')

    selects.each(function(){
      if($(this).val() == '' && $(this).hasClass('error') != true){
          $(this).addClass('error').parent().append('<label for="'+$(this).attr('name')+'" class="error">'+'<?php echo elgg_echo('freshdesk:valid', array(), $lang) ?>'+'</label>');
      }
    });

    var inputs = form.find('input:visible');

    //loop through the input fields
    inputs.each(function(){
      if($(this).attr('name') != 'attachment'){
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

    var checkboxes = form.find('input[type="checkbox"]');

    // loop through check boxes
    checkboxes.each(function(){
      if($(this).attr('name') != 'ongoing' && !$(this).parent().parent().hasClass('hidden')){
        if($(this).prop('checked') == false && $(this).hasClass('error') != true){
          $(this).addClass('error').parent().append('<div class="error">'+'<?php echo elgg_echo('freshdesk:valid', array(), $lang) ?>'+'</div>');
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

  $('input[type="checkbox"]').on("change", function(){
    if($(this).hasClass("error")) {
      $(this).removeClass("error").parent().find("div.error").remove();
    }
  });
});

function focusCorrection(){
  CKEDITOR.instances['description'].focus();
}

</script>

<style>
.user_type {
  width:35%;
  display: inline-block;
  vertical-align:top;
}

#institution-wrapper, #other-wrapper, #retired-wrapper, #media-wrapper, #business-wrapper, #ngo-wrapper, #provincial-wrapper, #federal-wrapper, #municipal-wrapper, #international-wrapper, #community-wrapper {
  width:65%;
  display:inline-block;
  vertical-align:top;
}

fieldset.user-info {
  border: 1px solid #e5e5e5;
  padding:15px;
  margin-top:10px;
}
.user-info legend {
  position:relative;
  top:0;
  float:none;
  width:auto;
  margin-bottom: 0;
}

div.error {
  background: #f3e9e8;
  border-left: 5px solid #d3080c;
  padding: 2px 6px;
  margin-top: 3px;
  margin-bottom: 10px !important;
}

input.error {
  margin-bottom: 0 !important;
}

label.error {
  margin-bottom: 10px !important;
}

.date-section {
  display: inline-block;
  width: 50%;
}

.date-section input {
  width: 100% !important;
  max-width: 225px !important;
  border-radius: 4px;
}

.date-helper {
  margin-bottom: 5px;
  margin-top: -4px;
  font-size: 14px;
}

@media screen and (max-width: 600px) {
  .user_type {
    width:100%;
    display: inline-block;
    vertical-align:top;
  }

  #institution-wrapper, #other-wrapper, #retired-wrapper, #media-wrapper, #business-wrapper, #ngo-wrapper, #provincial-wrapper, #federal-wrapper, #municipal-wrapper, #international-wrapper, #community-wrapper {
    width:100%;
    display:inline-block;
    vertical-align:top;
  }
}

</style>
