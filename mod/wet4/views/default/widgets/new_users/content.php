<?php
/**
 * New users admin widget
 */

$num_display = sanitize_int($vars['entity']->num_display, false);
// set default value for display number
if (!$num_display) {
	$num_display = 5;
}

echo elgg_list_entities(array(
	'type' => 'user',
	'subtype'=> null,
	'full_view' => false,
	'pagination' => false,
	'limit' => $num_display
));

//EW - added styles to widget content to prevent users with badges displaying their badge very large
//     also made avatars a smaller size
?>
<style>

    .elgg-avatar{
        width: 50px;
    }

    .gcProfileBadge {

     width:28%;
     position:absolute;

}

    .gcProfileBadge-lower {
         position: absolute;
         margin-left: auto;
         margin-right: auto;
         left: 0;
         bottom: -16%;
         right: 0;
         pointer-events: none;
    }


    .img-responsive {
  display: block;
  max-width: 100%;
  height: auto; }
</style>
