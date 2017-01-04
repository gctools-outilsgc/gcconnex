<?php
/**
 * Save image form body
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
$photo = $vars['entity'];



$img = elgg_view_entity_icon($photo, 'large', array(
  //'href' => $image->getIconURL('master'),
    'href' => 'ajax/view/ajax/photo?guid=' . $photo->guid,
  'img_class' => 'tidypics-photo',
  'link_class' => 'elgg-lightbox',
  'id' => 'img',
    
));
echo '<div class="test">';
echo $img;
echo '</div>';
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'rotation':
            rotation($photo);
            break;
        
    }
}

//function to rotate image
function rotation($photo){

echo "<script>alert(\"la variable est nulle\")</script>"; 
$picture_size = array($photo->thumbnail, $photo->smallthumb, $photo->largethumb);

  for($x = 0; $x < 3; $x++) {
    $imgsrc = $_SERVER['DOCUMENT_ROOT'] .'1/'.$photo->owner_guid.'/'.$picture_size[$x];
      if (file_exists($imgsrc)) {
          $img = imagecreatefromjpeg($imgsrc);

            if ($img !== false) {
              $imgRotated = imagerotate($img,90,0);

                if ($imgRotated !== false) {
                  imagejpeg($imgRotated,$imgsrc,100);
                }
            }else{
                  echo 'img rotate false';
            }
        
        }else{
            echo'file exist error';
        }
        imagedestroy($img);
        imagedestroy($imgRotated);
    }
        
  }


//button image rotation
$image_src = elgg_get_site_url().'/photos/thumbnail/'.$photo->guid.'/large/'.$photo->largethumb;
echo'<div class="col-md-7 col-md-offset-5 mrgn-tp-md">';
echo'<span class="btn btn-default" onclick=rotate_ajax("'.$image_src.'")>'.elgg_echo('rotate:image').'</span></div>';

$btn_language =  '<ul class="nav nav-tabs nav-tabs-language">
  <li id="btnen"><a href="#" id="btnClicken">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr"><a href="#" id="btnClickfr">'.elgg_echo('lang:french').'</a></li>
</ul>';

echo $btn_language;
?>
<div class="tab-content tab-content-border">
<div class="en">
	<label for="title"><?php echo elgg_echo('title:en'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title, 'id' =>'title', 'class' => 'mrgn-bttm-md',)); ?>
</div>
<div class="fr">
	<label for="title2"><?php echo elgg_echo('title:fr'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'title2', 'value' => $title2, 'id' =>'title2', 'class' => 'mrgn-bttm-md',)); ?>
</div>
<div class="en">
	<label for="id"><?php echo elgg_echo('img:desc:en'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $description, 'id' => 'description',  'class' => 'mrgn-bttm-md',)); ?>
</div>

<div class="fr">
	<label for="id"><?php echo elgg_echo('img:desc:fr'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description2', 'value' => $description2, 'id' => 'description2',  'class' => 'mrgn-bttm-md',)); ?>
</div>
<div>
	<label for="tags" class="mrgn-tp-md"><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags, 'id' => 'tags', )); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div class="elgg-foot">
<?php
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
echo elgg_view('input/submit', array('value' => elgg_echo('save'), 'class' => 'mrgn-tp-md',));

echo'</div></div>';






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