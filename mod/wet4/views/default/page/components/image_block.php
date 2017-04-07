<?php
/**
 * image_block.php
 * Elgg image block pattern
 *
 * Common pattern where there is an image, icon, media object to the left
 * and a descriptive block of text to the right.
 * 
 * ---------------------------------------------------------------
 * |          |                                      |    alt    |
 * |  image   |               body                   |   image   |
 * |  block   |               block                  |   block   |
 * |          |                                      | (optional)|
 * ---------------------------------------------------------------
 *
 * @uses $vars['body']        HTML content of the body block
 * @uses $vars['image']       HTML content of the image block
 * @uses $vars['image_alt']   HTML content of the alternate image block
 * @uses $vars['class']       Optional additional class for media element
 * @uses $vars['id']          Optional id for the media element
 *
 * @package wet4
 * @author GCTools Team
 */

$checkPage = elgg_get_context();

$body = elgg_extract('body', $vars, '');
$image = elgg_extract('image', $vars, '');
$alt_image = elgg_extract('image_alt', $vars, '');
$test = $_SESSION[idpage];
$class = 'col-xs-12 mrgn-tp-sm ';
$additional_class = elgg_extract('class', $vars, '');

$reshared = elgg_extract('reshare', $vars, '');

if ($additional_class) {
	$class = "$class $additional_class";
}

$id = '';
if (isset($vars['id'])) {
	$id = "id=\"{$vars['id']}\"";
}



//elgg body appends the edit comment text box thing

if (elgg_get_context() == 'messages'){
    //tests to see if the image block is a message and don't display an image
    // I tried to make the whole block a link but elgg doesn't like that :(
$body = "<div class=\" mrgn-tp-sm col-sm-12\">$body</div>";

if ($image) {
	$image = "<div class=\"mrgn-tp-sm col-sm-2\">$image</div>";
}

if ($alt_image) {
	$alt_image = "<div class=\"elgg-image-alt\">$alt_image</div>";
}    
    
 echo <<<HTML

<div class="$class clearfix " $id>

	$alt_image$body

    <div class=" elgg-body clearfix edit-comment">
    
    </div>
</div>

HTML;
    
    
}else if(elgg_in_context('file_tools_selector')){ //for files and folders
    


if ($image) {
	$image = "<div class=\"mrgn-tp-sm col-xs-2\">$image</div>";
}

if ($alt_image) {
	$alt_image = '<div class="elgg-image-alt  col-xs-1 mrgn-tp-md">' . $alt_image . '</div>';
}
    
    //see if entity is file or folder
$entity = elgg_extract('subtype', $vars, '');
$guid = elgg_extract('guid', $vars, '');


    

//only display move link on files
if($entity == 'file' && elgg_is_logged_in() && elgg_get_logged_in_user_entity()->canEdit()){
    $body = '<div class="mrgn-tp-sm col-xs-9">' . $body . '</div>';
} else {
    $body = "<div class=\"mrgn-tp-sm col-xs-9\">$body</div>";
    $move_link = '';
}
 



echo <<<HTML

<div class="$class clearfix mrgn-bttm-sm" $id>
	$alt_image$image$body
    <div class=" elgg-body clearfix edit-comment">
    
    </div>
</div>
HTML;

}else if($reshared == true){ //for reshared items


    if(elgg_in_context('custom_index_widgets wire') || elgg_in_context('widgets')){
        if ($image) {
            $image = "<div class=\"mrgn-tp-sm col-xs-2\">$image</div>";        
        }
        $body = '<div class="col-xs-10">' . $body . '</div>';
    } else {
        if ($image) {
            $image = "<div class=\"mrgn-tp-sm col-xs-1\">$image</div>";
        }
        $body = '<div class="col-xs-11">' . $body . '</div>';
    }


    echo <<<HTML

<div class="$class clearfix mrgn-bttm-sm" $id>
	$image$body
</div>
HTML;

}else{
    
    $body = "<div class=\"mrgn-tp-sm col-xs-10 noWrap\">$body</div>";

if ($image) {
	$image = "<div aria-hidden=\"true\" class=\"mrgn-tp-sm col-xs-2\">$image</div>";
     //$echo = elgg_get_context();
}

if ($alt_image) {
	$alt_image = "<div class=\"elgg-image-alt\">$alt_image</div>";
   
}

echo <<<HTML

<article class="$class mrgn-bttm-sm" $id>

	$image$alt_image$body$echo
    <div class="clearfix"></div>
    <div class=" elgg-body edit-comment">
   
    </div>
</article>
<div class="clearfix"></div>
HTML;

}