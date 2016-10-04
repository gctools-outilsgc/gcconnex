<?php
/**
 * Elgg user icon
 *
 * Rounded avatar corners - CSS3 method
 * uses avatar as background image so we can clip it with border-radius in supported browsers
 *
 * @uses $vars['entity']     The user entity. If none specified, the current user is assumed.
 * @uses $vars['size']       The size - tiny, small, medium or large. (medium)
 * @uses $vars['use_hover']  Display the hover menu? (true)
 * @uses $vars['use_link']   Wrap a link around image? (true)
 * @uses $vars['class']      Optional class added to the .elgg-avatar div
 * @uses $vars['img_class']  Optional CSS class added to img
 * @uses $vars['link_class'] Optional CSS class for the link
 * @uses $vars['href']       Optional override of the link href
 */

$user = elgg_extract('entity', $vars, elgg_get_logged_in_user_entity());
$size = elgg_extract('size', $vars, 'medium');
$icon_sizes = elgg_get_config('icon_sizes');
if (!array_key_exists($size, $icon_sizes)) {
	$size = 'medium';
}

/*if(elgg_get_context() == 'friends'){
    $size = 'medium';
}
if(elgg_get_context() == 'profile'){
    $size = 'large';
}*/

if (!($user instanceof ElggUser)) {
	return;
}


$name = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8', false);
$username = $user->username;

//prevents placing wet4 class on image to create a bigger image (used in user profile, profile card, user hover menu, avatar creation)
$force_size = elgg_extract('force_size', $vars);

if($force_size){
    $class = "elgg-avatar ";
} else {
    $class = "elgg-avatar elgg-avatar-$size-wet4 ";
}


if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

if ($user->isBanned()) {
	$class .= ' elgg-state-banned';
	$banned_text = elgg_echo('banned');
	$name .= " ($banned_text)";
}
echo elgg_echo($icon_size);
$use_link = elgg_extract('use_link', $vars, true);

$icontime = $user->icontime;
if (!$icontime) {
	$icontime = "default";
}

$js = elgg_extract('js', $vars, '');
if ($js) {
	elgg_deprecated_notice("Passing 'js' to icon views is deprecated.", 1.8, 5);
}
//Circle Images by adding img-circle class
$img_class = 'img-responsive img-circle';
if (isset($vars['img_class'])) {
	$img_class = $vars['img_class'];
}


$use_hover = elgg_extract('use_hover', $vars, true);
if (isset($vars['override'])) {
	elgg_deprecated_notice("Use 'use_hover' rather than 'override' with user avatars", 1.8, 5);
	$use_hover = false;
}
if (isset($vars['hover'])) {
	// only 1.8.0 was released with 'hover' as the key
	$use_hover = $vars['hover'];
}


$show_menu = $use_hover && (elgg_is_admin_logged_in() || !$user->isBanned());

?>
<div class="<?php echo $class; ?>">
<?php

if ($show_menu) {
	$params = array(
		'entity' => $user,
		'username' => $username,
		'name' => $name,
	);
	echo elgg_view_icon('hover-menu');
	echo elgg_view('navigation/menu/user_hover/placeholder', array('entity' => $user));
}


/*
 * GC tools ambassador badge
 * loading in the badge based on metadata
 * placed over user's avatar
 */


//check if plugin is active
if(elgg_is_active_plugin('gcProfilePictureBadges')){
    //see what badge they have
    if($user->active_badge != 'none' && $user->active_badge != ''){

        //load badge
        $badge = '<div class="gcProfileBadge">';

        /* Badges
         *
         *  Top left green - amb_badge_v1_2.png
         *  Top left red - amb_badge_v1_5.png
         *  Bottom green - amb_badge_1.png
         *  Bottom red - amb_badge_v1_4.png
         *
         */
        $badge .= elgg_view('output/img', array(
            'src' => 'mod/gcProfilePictureBadges/graphics/amb_badge_v1_5.png',
            'class' => 'img-responsive',
            'title' => 'GC Tools Ambassador',
        ));
        $badge .= '</div>';

        //add border to avatar
        //ambBorder1 => green border
        //ambBorder2 => gold border
        $badgeBorder = ' ambBorder2';
    }
}


$icon = elgg_view('output/img', array(
    'src' => $user->getIconURL($size),
    'alt' => $name,
    'title' => $name,
    'class' => $img_class . $badgeBorder,
));


//check to see if we dont want to show badge on this avatar
//passed to us by the 'show_badge'
$displayBadge = elgg_extract('show_badge', $vars, true);

//dont have a badge if false was passed to us
if($displayBadge != true){
    $badge = '';
}

if ($use_link) {
	$class = elgg_extract('link_class', $vars, '');
	$url = elgg_extract('href', $vars, $user->getURL());



	echo elgg_view('output/url', array(
		'href' => $url,
		'text' => $badge . $icon,
		'is_trusted' => true,
		'class' => $class,
	));

} else {

	echo "<span>$badge  $icon</span>";
}
?>
</div>
