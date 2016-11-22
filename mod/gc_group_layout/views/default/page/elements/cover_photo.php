<?php

/**
 * Allows users to add a 'cover photo' to their group. This view contains a div that can display a colored box or an image above the group summary.
 *
 * cover_photo description.
 *
 * @version 1.0
 * @author Nick
 */

$site_url = elgg_get_site_url();
$page_owner_guid_c_photo = elgg_get_page_owner_guid();
$cover_photo = elgg_get_page_owner_entity()->cover_photo;

//If the Metadata is the word 'nope' or not set do not show the cover photo div
if($cover_photo == 'nope' || $cover_photo ==''){

    $cover_photo_holder = '';

   }else{
    //Nick - The img src is sent to a page in the wet4 mod to grab the image from the data folder
    //Nick - Mapping directly to the data folder is dangerous according to elgg community
       $cover_photo_link = $site_url . 'mod/wet4/pages/c_photo_image.php?file_guid='.$page_owner_guid_c_photo;
       $cover_photo_link = elgg_format_url($cover_photo_link);

       //Format Image
       $test_photo = elgg_view('output/img', array(
               'src'=>$cover_photo_link,
               'alt'=>elgg_echo('wet:cover_photo_alt'),
           ));

       $cover_photo_holder = '<div><div class="group-cover-photo">'.$test_photo.'</div></div>';
}

echo $cover_photo_holder;
?>
