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
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title, 'id' => 'title')); ?>
</div>

<div class="mrgn-bttm-md fr">
	<label for="title2"><?php echo elgg_echo('title:fr'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title2', 'value' => $title2, 'id' => 'title2')); ?>
</div>
<div class="quick-start-collapse">
    
    
<div class="mrgn-bttm-md en">
	<label for="description"><?php echo elgg_echo('groups:topicmessage'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc, 'id' => 'description')); ?>
</div>

<div class="mrgn-bttm-md fr">
	<label for="description2"><?php echo elgg_echo('groups:topicmessage2'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description2', 'value' => $desc2, 'id' => 'description2')); ?>
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
               
        })
});
</script>