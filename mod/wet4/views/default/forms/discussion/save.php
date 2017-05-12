<?php
/**
 * Discussion topic add/edit form body
 *
 */

$title = elgg_extract('title', $vars, '');
$title2 = elgg_extract('title2', $vars, '');

$desc = elgg_extract('description', $vars, '');
$desc2 = elgg_extract('description2', $vars, '');
$status = elgg_extract('status', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);


$btn_language =  '<ul class="nav nav-tabs nav-tabs-language">
  <li id="btnen"><a href="#" id="btnClicken">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr"><a href="#" id="btnClickfr">'.elgg_echo('lang:french').'</a></li>
</ul>';

echo $btn_language;
?>
<div class="tab-content tab-content-border">
<div class="mrgn-bttm-md en">
	<label for="title"><?php echo elgg_echo('title:en'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title, 'id' => 'title', 'required '=> "required")); ?>
</div>

<div class="mrgn-bttm-md fr">
	<label for="title2"><?php echo elgg_echo('title:fr'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title2', 'value' => $title2, 'id' => 'title2', 'required '=> "required")); ?>
</div>
<div class="quick-start-collapse">


<div class="mrgn-bttm-md en">
	<label for="description"><?php echo elgg_echo('groups:topicmessage'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc, 'id' => 'description', 'class' => 'validate-me', 'required '=> "required")); ?>
</div>

<div class="mrgn-bttm-md fr">
	<label for="description2"><?php echo elgg_echo('groups:topicmessage2'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description2', 'value' => $desc2, 'id' => 'description2', 'class' => 'validate-me', 'required '=> "required")); ?>
</div>
<div>
	<label for="tags"><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags, 'id' => 'tags')); ?>
</div>
</div>
<div class="quick-start-hide">
<div class="mrgn-bttm-md">
    <label for="status"><?php echo elgg_echo("groups:topicstatus"); ?></label><br />
	<?php
		echo elgg_view('input/select', array(
			'name' => 'status',
            'id' => 'status',
			'value' => $status,
			'options_values' => array(
				'open' => elgg_echo('status:open'),
				'closed' => elgg_echo('status:closed'),
			),
		));
    ?>
</div>

<div class="mrgn-bttm-md">
	<label for="access_id"><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array(
		'name' => 'access_id',
		'value' => $access_id,
        'id' => 'access_id',
		'entity' => get_entity($guid),
		'entity_type' => 'object',
		'entity_subtype' => 'groupforumtopic',
	)); ?>
</div>
</div>
<div class="quick-start-collapse">
    <div class="elgg-foot">
        <?php
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'topic_guid', 'value' => $guid));
}
if($guid){
    echo elgg_view('input/submit', array('value' => elgg_echo('save'), 'class' => 'btn btn-primary'));
} else {
    echo elgg_view('input/submit', array('value' => 'Create Discussion', 'class' => 'btn btn-primary'));
}


echo'</div></div></div>';

if(get_current_language() == 'fr'){
?>
    <script>
        jQuery('.fr').show();
        jQuery('.en').hide();
        jQuery('#btnfr').addClass('active');

        $('#description').removeClass('validate-me');
    </script>
<?php
}else{
?>
    <script>
        jQuery('.en').show();
        jQuery('.fr').hide();
        jQuery('#btnen').addClass('active');

        $('#description2').removeClass('validate-me');
    </script>
<?php
}
?>
<script>
jQuery(function(){

    var selector = '.nav-tabs-language li';

$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

        jQuery('#btnClickfr').click(function(){
               jQuery('.fr').show();
               jQuery('.en').hide();

               $('#description').removeClass('validate-me');
               $('#description2').addClass('validate-me');
        });

          jQuery('#btnClicken').click(function(){
               jQuery('.en').show();
               jQuery('.fr').hide();

               $('#description').addClass('validate-me');
               $('#description2').removeClass('validate-me');
        })
});

$(".quick-start-form-tabindex").each(function(){
  $(this).validate({
 invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if (errors) {

             var element = validator.errorList[0].element;

             //check to see if textarea
             if($(element).is('textarea:hidden')){
               for(var i in CKEDITOR.instances){
                 if(CKEDITOR.instances[i].name == $(element).attr('name') || CKEDITOR.instances[i].name == $(element).attr('id')){
                   $('#cke_'+$(element).attr('id')).attr('aria-labelledby', $(element).attr('id')+'-error');
                   CKEDITOR.instances[i].focus();
                 }
               }
             } else {
               validator.errorList[0].element.focus();
             }
           }
       },
       submitHandler: function(form) {
         $(form).find('button').prop('disabled', true);
         form.submit();
       },
 ignore: ':hidden:not(.validate-me)',
  rules: {
    generic_comment: {
       required: true
   },
   description: {
      required: true
   },
    description2: {
      required: true
    },/*
   password2: {
     required: true,
     equalTo: "#password"
   },
   email: {
     required: true,
     equalTo: "#email_initial"
   }*/
 }
});
});
require(['ckeditor'], function(CKEDITOR) {
 //deal with copying the ckeditor text into the actual textarea
    CKEDITOR.on('instanceReady', function () {
       $.each(CKEDITOR.instances, function (instance) {
            CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
            CKEDITOR.instances[instance].document.on("paste", CK_jQ);
          //  CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
          //  CKEDITOR.instances[instance].document.on("blur", CK_jQ);
         //  CKEDITOR.instances[instance].document.on("change", CK_jQ);
        });
    });

    function CK_jQ() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
      }
    }
});
</script>
