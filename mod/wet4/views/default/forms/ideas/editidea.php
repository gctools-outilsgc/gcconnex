<?php
/**
 * Edit / add an idea
 *
 * @package ideas
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()

$title = elgg_extract('title', $vars, '');
$title1 = elgg_extract('title1', $vars, '');
$title2 = elgg_extract('title2', $vars, '');
$desc = elgg_extract('description', $vars, '');
$desc1 = elgg_extract('description1', $vars, '');
$desc2 = elgg_extract('description2', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);

$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);

$french = elgg_view('input/button', array(
    'value' => elgg_echo('btn:translate:fr'),
    'id' => 'btnClickfr',
    'class' => 'btn btn-default en',
));

$english = elgg_view('input/button', array(
    'value' => elgg_echo('btn:translate:en'),
    'id' => 'btnClicken',
    'class' => 'btn btn-default fr',
));

echo $body .= $french.' '.$english;
?>

<div class='en'>
	<label><?php echo elgg_echo('title:en'); ?></label><br />
	<?php
    if($title1){
        $title = $title1;   
    }

    if($desc1){
        $desc = $desc1;   
    }
	if (elgg_is_admin_logged_in()) {
		echo $title;
	} else {
		echo $title;
	}
    ?>
</div>
<div class='fr'>
	<label><?php echo elgg_echo('title:fr'); ?></label><br />
	<?php
	if (elgg_is_admin_logged_in()) {
		echo $title2;
	} else {
		echo $title2;
	}
    ?>
</div>

<div class='en'>
    <label for="description"><?php echo elgg_echo('description:ideas:en'); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'description', 'id' => 'description', 'value' => $desc)); ?>
</div>

<div class='fr'>
    <label for="description"><?php echo elgg_echo('description:ideas:fr'); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'description2', 'id' => 'description2', 'value' => $desc2)); ?>
</div>

<div>
	<label for="tags"><?php echo elgg_echo('tags'); ?></label>
    <?php echo elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags', 'value' => $tags)); ?>
</div>
<?php
	$categories = elgg_view('input/categories', $vars);
	if ($categories) {
		echo $categories;
	}
?>

<div class="elgg-foot mtl">
	<?php

	echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

	if ($guid) {
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
	}

	echo elgg_view('input/submit', array('value' => elgg_echo("save"), 'class' => 'btn btn-primary'));

	
echo'</div>';

if(get_current_language() == 'fr'){
?>
    <script>
        jQuery('.fr').show();
        jQuery('.en').hide();

    </script>
<?php
}else{
?>
    <script>
        jQuery('.en').show();
        jQuery('.fr').hide();

    </script>
<?php
}
?>
<script>
jQuery(function(){

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