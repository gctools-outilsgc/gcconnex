<?php
/**
 * Full view of an image
 *
 * @uses $vars['entity'] TidypicsImage
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 *
 * GC_MODIFICATION
 * Description: Style changes / added wet classes
 * Author: GCTools Team
 */
$lang = get_current_language();
$image = $photo = $vars['entity'];
$album = $image->getContainerEntity();

if(($photo->description2) && ($photo->description)){
	echo'<div id="change_language" class="change_language">';
	if (get_current_language() == 'fr'){

		?>			
		<span id="indicator_language_en" onclick="change_en('.elgg-output');"><span id="en_content" class="testClass hidden" ><?php echo $photo->description;?></span><span id="fr_content" class="testClass hidden" ><?php echo $photo->description2;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
			</span></span>
		<?php

	}else{
				
		?>			
		<span id="indicator_language_fr" onclick="change_fr('.elgg-output');"><span id="en_content" class="testClass hidden" ><?php echo $photo->description;?></span><span id="fr_content" class="testClass hidden" ><?php echo $photo->description2;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
		<?php	
	}
	echo'</div>';
}


$img = elgg_view_entity_icon($image, 'large', array(
	//'href' => $image->getIconURL('master'),
    'href' => 'ajax/view/ajax/photo?guid=' . $image->guid,
	'img_class' => 'tidypics-photo',
	'link_class' => 'elgg-lightbox',
	'id' => 'img',
    
));

$owner_link = elgg_view('output/url', array(
	'href' => "photos/owner/" . $photo->getOwnerEntity()->username,
	'text' => $photo->getOwnerEntity()->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($image->time_created);

$owner_icon = elgg_view_entity_icon($photo->getOwnerEntity(), 'medium');

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'photos',
	'sort_by' => 'priority',
	'class' => 'list-inline',
));

$subtitle = "$author_text $date";

$params = array(
	'entity' => $photo,
	'title' => false,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'tags' => $tags,
);
$list_body = elgg_view('object/elements/summary', $params);

$params = array('class' => 'mbl');
$summary = elgg_view_image_block($owner_icon, $list_body, $params);

echo $summary;

echo '<div class=" center">';
if ($album->getSize() > 1) {
        echo elgg_view('object/image/navigation', $vars);
}
echo elgg_view('photos/tagging/help', $vars);
echo elgg_view('photos/tagging/select', $vars);
echo $img;

echo'<button onclick="rotate()">ROTATION</button>';
echo'<div id="test" class="test">hello</div>';

//echo '<img src="http://localhost/gcconnex/photos/thumbnail/588/large/" id="img"/>';
//echo '<img src="C:/wamps/www/1/95/iamge/587/largethumb1481811100minions.jpg" id="img"/>';


//if (file_exists($_SERVER['DOCUMENT_ROOT'] .'1/95/image/587/largethumb1481811100minions.jpg')) {
/*	echo'YES!';
	echo $_SERVER['DOCUMENT_ROOT'] .  '1/95/image/377/largethumb1481733804minions';
}else{
	echo'No!';
	echo $_SERVER['DOCUMENT_ROOT'];
}*/
?>

<?php

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'insert':
            insert();
            break;
        case 'select':
            select();
             break;
        case 'test':
            test();
            break;
    }
}

function select() {
    echo "The select function is called.";
    exit;
}

function insert() {
    echo "The insert function is called.";
    exit;
}

function test(){

echo "The test function is called.";

$imgsrc = $_SERVER['DOCUMENT_ROOT'] .'1/95/image/587/largethumb1481811100minions.jpg';

//$imgsrc = $_SERVER['DOCUMENT_ROOT'] .'1/95/image/587/largethumb1481811100minions.jpg';
    if (file_exists($imgsrc)) {
    $img = imagecreatefromjpeg($imgsrc);



    if ($img !== false) {

    $imgRotated = imagerotate($img,90,0);

/*    $backgroundcolor = imagecolorallocate($imgRotated, 255, 255, 255);
    imagefill($imgRotated, 0, 0, $backgroundcolor);*/

    if ($imgRotated !== false) {
      imagejpeg($imgRotated,$imgsrc,100);
        }else{
        	echo 'img rotate false';
        }
    }else{
echo 'false';
    }
}else{
        echo'file exist error';
    }

}

echo elgg_view('photos/tagging/tags', $vars);
echo '</div>';

// alternative way to display the fivestar rating widget in case the default view defined in Elggx Fivestar is not to be used
// if (elgg_is_active_plugin('elggx_fivestar')) {
//     echo '<br>';
//     echo elgg_view('elggx_fivestar/voting', array('entity'=> $vars['entity']));
// }

if ($photo->description) {
	if (empty(gc_explode_translation($photo->description3, $lang))){
	$description = $photo->description;
}else{
$description = gc_explode_translation($photo->description3, $lang);
}
	echo elgg_view('output/longtext', array(
		'value' => $description,
		'class' => 'mbl mrgn-tp-md mrgn-bttm-md',
	));
}
//echo '<h2 class="panel-title mrgn-lft-sm mrgn-bttm-md mrgn-tp-lg">' . elgg_echo("comments") . '</h2>';
echo elgg_view_comments($photo);
