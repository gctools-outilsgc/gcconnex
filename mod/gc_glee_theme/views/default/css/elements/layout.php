<?php
/**
 * Page Layout
 *
 * Contains CSS for the page shell and page layout
 *
 * Default layout: 990px wide, centered. Used in default page shell
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>

/* ***************************************
	PAGE LAYOUT
*************************************** */
/***** DEFAULT LAYOUT ******/
<?php // the width is on the page rather than topbar to handle small viewports ?>
.elgg-page-default {
	min-width: 998px;
}
.elgg-page-default .elgg-page-header > .elgg-inner {
	margin: 0 auto;
	max-height: 25px;
}
.elgg-page-default .elgg-page-body > .elgg-inner {
	margin: 0 auto;
}
.elgg-page-default .elgg-page-footer > .elgg-inner {
	margin: 0 auto;
	padding: 5px 0;
	border-top: 1px solid #EEEEEE;
}

/***** TOPBAR ******/
.elgg-page-topbar {

}
.elgg-page-topbar > .elgg-inner {

}


/***** PAGE MESSAGES ******/
.elgg-system-messages {
	position: fixed;
	top: 44px;
	right: 20px;
	max-width: 500px;
	z-index: 2000;
}
.elgg-system-messages li {
	margin-top: 10px;
}
.elgg-system-messages li p {
	margin: 0;
}

/***** PAGE HEADER ******/
.elgg-page-header {
   margin: 0 0 18px 0;
}
.elgg-page-header > .elgg-inner {

}

/***** PAGE BODY LAYOUT ******/
.elgg-layout {
	min-height: 360px;
}

.elgg-layout-one-sidebar {

}
.elgg-layout-two-sidebar {

}


.elgg-layout-error {
	margin-top: 20px;
}
.elgg-sidebar {
	position: relative;
	padding: 5px 5px;
	float: right;
	width: 180px;
	margin: 0 0 0 10px;
	min-height: 5px;	    
}
.elgg-sidebar-alt {
	position: relative;
	padding: 20px 10px;
	float: left;
	width: 160px;
	margin: 0 10px 0 0;
	min-height: 200px;
}
.elgg-main {
	position: relative;
	min-height: 360px;
	padding: 0px;
}
.elgg-main > .elgg-head {
	padding-bottom: 3px;
	border-bottom: 1px solid #CCCCCC;
	margin-bottom: 10px;
}

/***** PAGE FOOTER ******/
.elgg-page-footer {
	position: relative;
}
.elgg-page-footer {
	/*color: #999;*/
}
.elgg-page-footer a:hover {
	/*color: #666;*/
}