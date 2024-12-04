<?php
/**
 * Form component for editing a single image
 *
 * @uses $vars['entity']
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels + content translation support
 * Author: GCTools Team
 */

$image = $vars['entity'];
$imageGUID = $image->getGUID();

echo '<div class="elgg-image-block">';

echo '<div class="elgg-image">';
echo elgg_view_entity_icon($image, 'small', array('href' => false));

echo '</div>';

echo '<div class="elgg-body"><fieldset class="mlm">';
echo '<div class="en"><label for="title-'.$imageGUID.'">' . elgg_echo('title:en') . '</label>';
echo elgg_view('input/text', array('name' => 'title[]', 'value' => $title, 'id'=>'title-'.$imageGUID,));
echo '</div>';

echo '<div class="fr"><label for="title2-'.$imageGUID.'">' . elgg_echo('title:fr') . '</label>';
echo elgg_view('input/text', array('name' => 'title2[]', 'value' => $title2, 'id'=>'title2-'.$imageGUID,));
echo '</div>';

echo '<div class="en"><label for="caption-'.$imageGUID.'">' . elgg_echo('caption:en') . '</label>';
echo elgg_view('input/longtext', array('name' => 'caption[]', 'id'=>'caption-'.$imageGUID,));
echo '</div>';

echo '<div class="fr"><label for="caption2-'.$imageGUID.'">' . elgg_echo('caption:fr') . '</label>';
echo elgg_view('input/longtext', array('name' => 'caption2[]', 'id'=>'caption2-'.$imageGUID,));
echo '</div>';

echo '<div><label for="tags-'.$imageGUID.'">' . elgg_echo("tags") . '</label>';
echo elgg_view('input/tags', array('name' => 'tags[]', 'id'=>'tags-'.$imageGUID,));
echo '</div>';

echo elgg_view('input/hidden', array('name' => 'guid[]', 'value' => $image->getGUID()));
echo '<fieldset></div>';

echo '</div>';


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
