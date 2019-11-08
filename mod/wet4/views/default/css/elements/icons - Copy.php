<?php
/**
 * Elgg icons
 *
 * @package Elgg.Core
 * @subpackage UI
 */

?>
/* <style> /**/

/* ***************************************
	ICONS
*************************************** */

.elgg-icon {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png) no-repeat left;
	width: 16px;
	height: 16px;
	margin: 0 2px;
}

/* DO NOT DELETE */
.elgg-icon-delete-alt-hover,
.elgg-icon-delete-alt:hover,
:focus > .elgg-icon-delete-alt {
	background-position: 0 -216px;
}
.elgg-icon-delete-alt {
	background-position: 0 -234px;
}
.elgg-icon-delete-hover,
.elgg-icon-delete:hover,
:focus > .elgg-icon-delete {
	background-position: 0 -252px;
}
.elgg-icon-delete {
	background-position: 0 -270px;
}

.elgg-icon-hover-menu-hover,
.elgg-icon-hover-menu:hover,
:focus > .elgg-icon-hover-menu {
	background-position: 0 -432px;
}
.elgg-icon-hover-menu {
	background-position: 0 -450px;
}

.elgg-icon-info-hover,
.elgg-icon-info:hover,
:focus > .elgg-icon-info {
	background-position: 0 -468px;
}
.elgg-icon-info {
	background-position: 0 -486px;
}

/* DO NOT DELETE */
.elgg-icon-link-hover,
.elgg-icon-link:hover,
:focus > .elgg-icon-link {
	background-position: 0 -504px;
}
.elgg-icon-link {
	background-position: 0 -522px;
}
.elgg-icon-list {
	background-position: 0 -540px;
}
.elgg-icon-lock-closed {
	background-position: 0 -558px;
}
.elgg-icon-lock-open {
	background-position: 0 -576px;
}

.elgg-icon-undo {
	background-position: 0 -1422px;
}
.elgg-icon-user-hover,
.elgg-icon-user:hover,
:focus > .elgg-icon-user {
	background-position: 0 -1440px;
}
.elgg-icon-user {
	background-position: 0 -1458px;
}
.elgg-icon-users-hover,
.elgg-icon-users:hover,
:focus > .elgg-icon-users {
	background-position: 0 -1476px;
}
.elgg-icon-users {
	background-position: 0 -1494px;
}

/* DO NOT DELETE */
.elgg-avatar > .elgg-icon-hover-menu {
	display: none;
	position: absolute;
	right: 0;
	bottom: 0;
	margin: 0;
	cursor: pointer;
}
/* DO NOT DELETE */
.elgg-ajax-loader {
    display:none;
}

/* ***************************************
	AVATAR ICONS
*************************************** */
.elgg-avatar {
	position: relative;
	display: inline-block;
}
.elgg-avatar > a > img {
	display: block;
}
.elgg-avatar-tiny > a > img {
	width: 25px;
	height: 25px;
	
	/* remove the border-radius if you don't want rounded avatars in supported browsers */
	border-radius: 3px;
	
	background-clip:  border;
	background-size: 25px;
}
.elgg-avatar-small > a > img {
	width: 40px;
	height: 40px;
	/* remove the border-radius if you don't want rounded avatars in supported browsers */
	border-radius: 5px;
	background-clip:  border;
	background-size: 40px;
}
.elgg-avatar-medium > a > img {
	width: 100px;
	height: 100px;
}
.elgg-avatar-large {
	width: 100%;
}
.elgg-avatar-large > a > img {
	width: 100%;
	height: auto;
}
.elgg-state-banned {
	opacity: 0.5;
}