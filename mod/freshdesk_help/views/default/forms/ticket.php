<?php
$lang = (string) get_input('lang');
$source = 'embed';
$product_id  = (int) elgg_get_plugin_setting("embed_product_id", "freshdesk_help");

$types = array();
$types['None'] = elgg_echo('freshdesk:ticket:types:none', array(), $lang);
$types['Account creation | Création de compte'] = elgg_echo('freshdesk:ticket:types:account', array(), $lang);
$types['Log in credentials | Identifiants de connexions'] = elgg_echo('freshdesk:ticket:types:login', array(), $lang);
$types['Bugs/Errors | Bogues/erreurs'] = elgg_echo('freshdesk:ticket:types:bugs', array(), $lang);
$types['Group-related | Relatif aux groupes'] = elgg_echo('freshdesk:ticket:types:group', array(), $lang);
$types['Data Request | Demande de données']  = elgg_echo('freshdesk:ticket:types:data', array(), $lang);
$types['Training | Formation'] = elgg_echo('freshdesk:ticket:types:training', array(), $lang);
$types["Jobs Marketplace | Carrefour d'emploi"] = elgg_echo('freshdesk:ticket:types:jobs', array(), $lang);
$types['Enhancement | Amélioration'] = elgg_echo('freshdesk:ticket:types:enhancement', array(), $lang);
$types['Wiki coding | Codage wiki'] = elgg_echo('freshdesk:ticket:types:wiki', array(), $lang);
$types['Flag content or behaviour | Signaler un contenu ou comportement'] = elgg_echo('freshdesk:ticket:types:flag', array(), $lang);
$types['Other | Autres'] = elgg_echo('freshdesk:ticket:types:other', array(), $lang);

if(!$lang){
  $lang = get_current_language();
  $source = 'base';
  $product_id  = (int) elgg_get_plugin_setting("product_id", "freshdesk_help");
  unset($types['Wiki coding | Codage wiki']);
} else {
  unset($types['Group-related | Relatif aux groupes']);
  unset($types["Jobs Marketplace | Carrefour d'emploi"]);
  unset($types['Enhancement | Amélioration']);
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

  <div class="mrgn-tp-sm">
    <?php
    if(  $product_id == 2100000289 || $product_id == 2100000298){
    	echo '<label for="department">'.elgg_echo('freshdesk:ticket:department').'</label>';
    	echo elgg_view('input/department_field');
    } else {
      echo elgg_view('input/user_type_field');
    }
    ?>
  </div>
</fieldset>

<fieldset class="user-info">
  <legend><?php echo elgg_echo('freshdesk:ticket:legend:ticketinfo', array(), $lang); ?></legend>
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
    'options_values' => $types,
  ));
  ?>
  </div>

  <div class="mrgn-tp-sm">
  <label for="attachment"><?php echo elgg_echo('freshdesk:ticket:attachment', array(), $lang); ?></label>
  <?php echo elgg_view('input/file', array('name' => 'attachment', 'id' => 'attachment', 'class' => 'mrgn-bttm-sm')); ?>
  </div>

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
    if($.trim($(description).val()) == '' && $(description).hasClass('error') != true){
      $(description).addClass('error').parent().append('<label id="description-error" for="cke_'+$(description).attr('name')+'" class="error">'+'<?php echo elgg_echo('freshdesk:valid', array(), $lang) ?>'+'</label>');
      $('#cke_'+$(description).attr('id')).attr('aria-labelledby', $(description).attr('id')+'-error');
    } else if($.trim($(description).val()) != ''){
      $(description).removeClass('error');
      $('#description-error').remove();
    }

    var selects = form.find('select:visible')

    selects.each(function(){
      if($(this).val() == 'None' && $(this).hasClass('error') != true){
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
  padding:5px 10px 10px;
  margin-top:10px;
}
.user-info legend {
  position:relative;
  top:0;
  float:none;
  width:auto;
  margin-bottom: 0;
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
