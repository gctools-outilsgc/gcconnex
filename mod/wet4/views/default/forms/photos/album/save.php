<?php
/**
 * Save album form body
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$title = elgg_extract('title', $vars, '');
$title2 = elgg_extract('title2', $vars, '');
$description = elgg_extract('description', $vars, '');
$description2 = elgg_extract('description2', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, get_default_access());
$container_guid = elgg_extract('container_guid', $vars, elgg_get_page_owner_guid());
$guid = elgg_extract('guid', $vars, 0);

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

<div class="en">
	<label for="title"><?php echo elgg_echo('album:title:en'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title, 'id' => 'title', 'class' => 'mrgn-bttm-md',)); ?>
</div>

<div class="fr">
	<label for="title2"><?php echo elgg_echo('album:title:fr'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'title2', 'value' => $title2, 'id' => 'title2', 'class' => 'mrgn-bttm-md',)); ?>
</div>
<div class="en">
	<label for="description"><?php echo elgg_echo('album:desc:en'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $description, 'id' => 'description',)); ?>
</div>
<div class="fr">
	<label for="description2"><?php echo elgg_echo('album:desc:fr'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description2', 'value' => $description2, 'id' => 'description2',)); ?>
</div>

<div>
	<label for="tags" class="mrgn-tp-md"><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags, 'id' => 'tags', 'class' => 'mrgn-bttm-md',)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label for="access_id"><?php echo elgg_echo('access'); ?></label>
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id, 'id' => 'access_id',)); ?>
</div>
<div class="elgg-foot">
<?php
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
echo elgg_view('input/submit', array('value' => elgg_echo('save'), 'class' => 'mrgn-tp-md btn btn-primary',));

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