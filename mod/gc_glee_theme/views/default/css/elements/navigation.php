<?php
/**
 * Navigation
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>

/* ***************************************
	PAGINATION
*************************************** */
.elgg-pagination {

}
.elgg-pagination li {

}
.elgg-pagination a, .elgg-pagination span {

}
.elgg-pagination a:hover {

} 
.elgg-pagination .elgg-state-disabled span {

}
.elgg-pagination .elgg-state-selected span {

}

/* ***************************************
	TABS
*************************************** */
.elgg-tabs {
	margin-bottom: 5px;
	border-bottom: 2px solid #cccccc;
	display: table;
	width: 100%;
}
.elgg-tabs li {
	float: left;
	border: 2px solid #ccc;
	border-bottom: 0;
	background: #eee;
	margin: 0 0 0 10px;
	
	-webkit-border-radius: 5px 5px 0 0;
	-moz-border-radius: 5px 5px 0 0;
	border-radius: 5px 5px 0 0;
}
.elgg-tabs a {
	text-decoration: none;
	display: block;
	padding: 3px 10px 0 10px;
	text-align: center;
	height: 21px;
	color: #999;
}
.elgg-tabs a:hover {
	background: #dedede;
	color: #2d2d2d;
}
.elgg-tabs .elgg-state-selected {
	border-color: #ccc;
	background: white;
}
.elgg-tabs .elgg-state-selected a {
	position: relative;
	top: 2px;
	background: white;
}

/* ***************************************
	BREADCRUMBS
*************************************** */
.elgg-breadcrumbs {

}
.elgg-breadcrumbs > li {

}
.elgg-breadcrumbs > li:after {

}
.elgg-breadcrumbs > li > a {

}
.elgg-breadcrumbs > li > a:hover {

}

.elgg-main .elgg-breadcrumbs {

}

/* ***************************************
	TOPBAR MENU
*************************************** */
.elgg-menu-topbar {

}

.elgg-menu-topbar > li {

}

.elgg-menu-topbar > li > a {

}

.elgg-menu-topbar > li > a:hover {

}

.elgg-menu-topbar-alt {

}

.elgg-menu-topbar .elgg-icon {

}

.elgg-menu-topbar > li > a.elgg-topbar-logo {

}

.elgg-menu-topbar > li > a.elgg-topbar-avatar {

}

/* ***************************************
	SITE MENU
*************************************** */
.elgg-menu-site {

}

.elgg-menu-site > li > a {

}

.elgg-menu-site > li > a:hover {

}

.elgg-menu-site-default {

}

.elgg-menu-site-default > li {

}

.elgg-menu-site-default > li > a {

}

.elgg-menu-site > li > ul {

}

.elgg-menu-site > li:hover > ul {

}

.elgg-menu-site-default > .elgg-state-selected > a,
.elgg-menu-site-default > li:hover > a {

}

.elgg-menu-site-more {

}

.elgg-menu-site-more > li > a {

}

.elgg-menu-site-more > li > a:hover {

}

.elgg-menu-site-more > li:last-child > a,
.elgg-menu-site-more > li:last-child > a:hover {

}

.elgg-more > a:before {

}
 
/* ***************************************
	TITLE
*************************************** */
.elgg-menu-title {
	float: right;
}

.elgg-menu-title > li {
	display: inline-block;
	margin-left: 4px;	
}
<!--[if lte IE7]>
.elgg-menu-title > li {
	zoom: 1; 
	display: inline; 
	height: 0;
	
}
<![endif]-->
/* ***************************************
	FILTER MENU
*************************************** */ 
.elgg-menu-filter {

}
.elgg-menu-filter > li {

}
.elgg-menu-filter > li:hover {

}
.elgg-menu-filter > li > a {

}
.elgg-menu-filter > li > a:hover {

}
.elgg-menu-filter > .elgg-state-selected {

}
.elgg-menu-filter > .elgg-state-selected > a {

}

/* ***************************************
	PAGE MENU
*************************************** */
.elgg-menu-page {

}

.elgg-menu-page a {

}
.elgg-menu-page a:hover {

}
.elgg-menu-page li.elgg-state-selected > a {

}
.elgg-menu-page .elgg-child-menu {

}
.elgg-menu-page .elgg-menu-closed:before, .elgg-menu-opened:before {

}
.elgg-menu-page .elgg-menu-closed:before {

}
.elgg-menu-page .elgg-menu-opened:before {

}

/* ***************************************
	HOVER MENU
*************************************** */
.elgg-menu-hover {
	display: none;
	position: absolute;
	z-index: 10000;

	overflow: hidden;

	min-width: 165px;
	max-width: 250px;
	border: solid 1px;
	border-color: #E5E5E5 #999 #999 #E5E5E5;
	background-color: #FFF;
	
	-webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.50);
	-moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.50);
	box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.50);
}
.elgg-menu-hover > li {
	border-bottom: 1px solid #ddd;
}
.elgg-menu-hover > li:last-child {
	border-bottom: none;
}
.elgg-menu-hover .elgg-heading-basic {
	display: block;
}
.elgg-menu-hover a {
	padding: 2px 8px;
	font-size: 92%;
}
.elgg-menu-hover a:hover {
	/*background: #ccc;*/
	text-decoration: none;
}
.elgg-menu-hover-admin a {
	color: red;
}
.elgg-menu-hover-admin a:hover {
	color: white;
	background-color: red;
}

/* ***************************************
	SITE FOOTER
*************************************** */
.elgg-menu-footer > li,
.elgg-menu-footer > li > a {
	display: inline-block;
	/*color: #2c2c2c;*/
}

.elgg-menu-footer > li:after {
	content: "\007C";
	padding: 0 4px;
}

.elgg-menu-footer-default {
	float: right;
}

.elgg-menu-footer-alt {
	float: left;
}

/* ***************************************
	GENERAL MENU
*************************************** */
.elgg-menu-general > li,
.elgg-menu-general > li > a {
	display: inline-block;
	/*color: #999;*/
}

.elgg-menu-general > li:after {
	content: "\007C";
	padding: 0 4px;
}

/* ***************************************
	ENTITY AND ANNOTATION
*************************************** */
<?php // height depends on line height/font size ?>
<?php /*GCchange - troy: strapline fix*/ ?>
.elgg-menu-entity, elgg-menu-annotation {
	float: left;
	margin-left: 0px;
	font-size: 90%;
	/*color: #aaa;*/
	line-height: 16px;
	width:100%;
}
<?php /*GCchange - troy: list spacing for strapline*/ ?>
.elgg-menu-entity > li, .elgg-menu-annotation > li {
	margin-right: 10px;
}
.elgg-menu-entity > li > a, .elgg-menu-annotation > li > a {
	/*color: #aaa;*/
}
<?php // need to override .elgg-menu-hz ?>
.elgg-menu-entity > li > a, .elgg-menu-annotation > li > a {
	display: block;
}
.elgg-menu-entity > li > span, .elgg-menu-annotation > li > span {
	vertical-align: baseline;
}

/* ***************************************
	OWNER BLOCK
*************************************** */
.elgg-menu-owner-block li a {

}
.elgg-menu-owner-block li a:hover {

}
.elgg-menu-owner-block li.elgg-state-selected > a {

}


/* ***************************************
	LONGTEXT
*************************************** */
.elgg-menu-longtext {
	float: right;
}

/* ***************************************
	RIVER
*************************************** */
.elgg-menu-river {
	float: right;
	margin-left: 15px;
	font-size: 90%;
	/*color: #aaa;*/
	line-height: 16px;
	height: 16px;
}
.elgg-menu-river > li {
	display: inline-block;
	margin-left: 5px;
}
.elgg-menu-river > li > a {
	/*color: #aaa;*/
	height: 16px;
}
<?php // need to override .elgg-menu-hz ?>
.elgg-menu-river > li > a {
	display: block;
}
.elgg-menu-river > li > span {
	vertical-align: baseline;
}

/* ***************************************
	SIDEBAR EXTRAS (rss, bookmark, etc)
*************************************** */
.elgg-menu-extras {
	margin-bottom: 2px;
}

/* ***************************************
	WIDGET MENU
*************************************** */
.elgg-menu-widget > li {
	position: absolute;
	top: 4px;
	display: inline-block;
	width: 18px;
	height: 18px;
	padding: 2px 2px 0 0;
}

.elgg-menu-widget > .elgg-menu-item-collapse {
	left: 5px;
}
.elgg-menu-widget > .elgg-menu-item-delete {
	right: 5px;
}
.elgg-menu-widget > .elgg-menu-item-settings {
	right: 25px;
}
