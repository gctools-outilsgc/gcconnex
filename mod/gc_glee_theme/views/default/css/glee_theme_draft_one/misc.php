<?php

$link_color  = glee_get_link_color();
?>
/**********************************
* Elgg / Bootstrap stuff
***********************************/
.glee-draft-one-logo {
    text-align: center;
    overflow:hidden;
}

/**********************************
* Elgg / Bootstrap stuff
***********************************/
.sidebar-nav {
	padding: 9px 0;
}

.elgg-page {
	position:relative;
	top:80px;
}

.elgg-page-body {
    margin: 0 0 20px 0;
}
    
.elgg-page-body > .elgg-inner { 
	min-height: 50px;
}

.elgg-page-default .elgg-page-header {
	margin: 0 0 0 0;
	padding: 0 0;
	border: none;
} 


/**********************************
* Typography
***********************************/

/*
.elgg-heading-site, .elgg-heading-site:hover {
	font-size: 1.5em;
	font-style: italic;
	font-family: Georgia, times, serif;
	text-shadow: 1px 2px 4px #999;
}*/
.elgg-heading-basic {
	color: <?php echo $link_color; ?>;
	font-size: 1.2em;
	font-weight: bold;
}


/**********************************
* Navigation
***********************************/
/* login form dropdown box */
ul.dropdown-menu > li > form.elgg-form-login {
    background-color: white;
    margin: 0;
    padding: 20px;
    
    width: 300px;
}

.breadcrumb.elgg-menu > li > a {
    display: inline-block;
}

ul.elgg-menu-hover,
ul.elgg-menu-hover li ul {
	margin-bottom:0;
}

.elgg-menu-hover-admin li > a:hover {
    background-color: red;
    color: white;
}

.elgg-menu-admin-footer li > a:hover {
    color: black;
}

/**********************************
* Modules
***********************************/
/* Featured */
.elgg-module-featured {
	border: 1px solid <?php echo $link_color; ?>;
}
.elgg-module-featured > .elgg-head {
	background-color: <?php echo $link_color; ?>;
}


/**********************************
* Profile
***********************************/
/* override ".nav > li > a:hover" */
.profile-content-menu li > a:hover {
	background: <?php echo $link_color; ?>;
	color: white;
	text-decoration: none;
}

/**********************************
* Forms
***********************************/
label input, label textarea, label select {
    display: inline-block;
}

.friends-picker-navigation li a.current {
	background: <?php echo $link_color; ?>;
	color:white !important;
}

.ui-autocomplete a:hover {
	text-decoration: none;
	color: <?php echo $link_color; ?>;
}

/**********************************
* Search
***********************************/
.elgg-search-topbar {
    padding: 11px 10px 0 15px;
}
.elgg-search input[type=text] {
	width: 130px;
	height: 16px;
	border: 1px solid #CCC;
}
.elgg-search input[type=text]:focus, .elgg-search input[type=text]:active {
	color: <?php echo $link_color; ?>;
}
/* ***************************************
	Profile
*************************************** */
.profile {
	float: left;
	margin-bottom: 15px;
}
.profile .elgg-inner {
	margin: 0 5px;
	border: 2px solid #eee;
	
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
}
#profile-details {
	padding: 15px;
}
/*** ownerblock ***/
#profile-owner-block {
	width: 200px;
	float: left;
	background-color: #eee;
	padding: 15px;
}
#profile-owner-block .large {
	margin-bottom: 10px;
}
#profile-owner-block a.elgg-button-action {
	margin-bottom: 4px;
	display: table;
}
.profile-content-menu a {
	display: block;
	border-radius: 8px;
	
	background-color: white;
	margin: 3px 0 5px 0;
	padding: 2px 4px 2px 8px;
}
.profile-content-menu a:hover {
	background: <?php echo $link_color; ?>;
	color: white;
	text-decoration: none;
}
