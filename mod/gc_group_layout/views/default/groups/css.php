<?php
/**
 * Elgg Groups css
 *
 * @package groups
 */

?>
.groups-profile > .elgg-image {
	margin-right: 20px;
}
.groups-stats {
	margin-top: 5px; <!-- change to 5 for better look for icon group (share, thumbs up and bell) -->
}
.groups-stats p {
	margin-bottom: 2px;
}
.groups-profile-fields div:first-child {
	padding-top: 0;
}

.groups-profile-fields .odd,
.groups-profile-fields .even {
	border-bottom: 1px solid #DCDCDC;
	padding: 5px 0;
	margin-bottom: 0;
}

.groups-profile-fields .elgg-output {
	margin: 0;
}

#groups-tools > li {
	width: 48%;
	min-height: 200px;
	margin-bottom: 40px;
}

#groups-tools > li:nth-child(odd) {
	margin-right: 4%;
}

.groups-widget-viewall {
	float: right;
	font-size: 85%;
}

.groups-latest-reply {
	float: right;
}

.elgg-menu-groups-my-status li a {
	color: #444;
	display: block;
	margin: 3px 0 5px 0;
	padding: 2px 4px 2px 0;
}
.elgg-menu-groups-my-status li a:hover {
	color: #999;
}
.elgg-menu-groups-my-status li.elgg-state-selected > a {
	color: #999;
}

.groups-info .list-inline li {
		padding:0 2px;
}

.group-summary-holder {
	z-index: 2;
  position: relative;
}

.elgg-menu-group-ddb {
	padding: 0 !important;
}

@media (max-width: 990px) and (min-width: 481px)
{
	.groups-info .pull-left {
  	float: none !important;
  }
}

@media (max-width: 480px)
{
	.group-summary-holder {
  	z-index: 2;
    position: relative;
		width: 100% !important;
  }

	.group-summary-holder .col-xs-9 {
		width:100% !important;
	}

	.group-action-holder {
		width: 100% !important;
	}
}
