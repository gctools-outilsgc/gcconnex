/*
 * ideas List
 */
.ideas-list .elgg-menu-item-likes, 
.ideas-list .elgg-menu-item-likes-count, 
.elgg-item-idea .elgg-menu-item-likes,
.elgg-item-idea .elgg-menu-item-likes-count {
    display: none;
}

.bpideas {
    display: none;
}

/*
 * Tab filter
 */
.UpDownArrow {
	background: transparent url('<?php echo elgg_get_site_url(); ?>/mod/ideas/graphics/UpDownArrow.png');
	float: right;
	height: 8px;
	margin: 6px 0 0 6px;
	width: 12px;
}
.up {
	background-position: 0 -8px;
}
.ideas-highlight {
	background: yellow;
}
#ideas-characters-remaining.loading {
	background: url('<?php echo elgg_get_site_url(); ?>/mod/ideas/graphics/ajax-loader.gif') no-repeat scroll 0 6px transparent;
	padding-left: 20px;
}
#ideas-search-response > span {
	margin-right: 5px;
	font-weight: bold;
	font-size: 1.2em;
}
#ideas-search-response > .elgg-list {
	margin-top: 10px;
}

/*
 * Object idea
 */
.elgg-item-idea {
	min-height: 80px;
	clear: both;
	overflow: hidden;
}
.elgg-body > .elgg-item-idea {
	float: none;
}
.idea-left-column {
	float: left;
	position: relative;
}
.idea-content {
	float: left;
	width: 80%;
}
.idea-content .elgg-menu-entity {
	/* position: absolute; */
	top: 0;
	right: 0;
}
.idea-content .elgg-image-block {
	float: left;
}
.idea-points {
	font-size: 2em;
	font-weight: bold;
	text-align: center;
	border: 1px solid #DEDEDE;
	border-radius: 5px;
	width: 50px;
	padding: 12px 0;
	margin: auto;
}
.idea-points .elgg-ajax-loader {
	background-size: 24px 24px;
	margin: -3px 0;
	min-height: 24px !important;
}
.idea-rate-button {
	width: 50px;
	border: 1px solid #CCCCCC;
	color: #666666;
	border-radius: 5px 5px 5px 5px;
	cursor: pointer;
	font-size: 14px;
	font-weight: bold;
	padding: 2px 0;
	text-align: center;
	display: block;
}
.idea-rate-button:hover {
	background: #CCC;
	text-decoration: none;
}
div.idea-rate-button {
	cursor: default;
}
div.idea-rate-button:hover {
	background: #EEE;
}

.idea-points span {
    font-size: .5em;
    font-weight: normal;
    display: block;
}

/*
.idea-value-0 {
	display: none;
}
.idea-value-1 {
	background: #FFC773;
}
.idea-value-2 {
	background: #FFB240;
}
.idea-value-3 {
	background: #FF9900;
}
*/

.idea-status {
	background: #EEE;
	clear: both;
}
.status {
	border-radius: 8px;
	color: #333;
	font-size: 11px;
	font-weight: normal;
	padding: 1px 8px;
	white-space: nowrap;
}
.elgg-river-message .status {
	border-radius: 5px;
	font-size: 9px;
	padding: 1px 5px 1px;
}
.status.open {
	border: 1px solid #DDD;
	background: white;
}
.status.planned {
	background: #FFED00;
}
.status.under_review {
	background: #BBB;
}
.status.started {
	background: #4690D6;
}
.status.completed {
	background: #89C23C;
}
.status.declined {
	background: #F33;
}
.elgg-menu-filter > li > a.status {
	border-radius: 3px 3px 0 0;
	color: #333;
}

.idea-vote-container {
    padding: 5px;
}

.elgg-item-idea {
    position: relative;
}

.idea-right-column {
    float: right;
    text-align: center;
    padding: 10px;
}

/*
 * Object vote-popup
 */
.ideas-vote-popup {
	display: none;
	position: absolute;
	z-index: 0;
	padding: 0px;
}
.ideas-vote-popup .triangle {
	border-style: solid;
	border-width: 10px 10px 10px 0;
	height: 0;
	position: absolute;
	width: 0;
	top: 6px;
}
.ideas-vote-popup .blanc {
	border-color: transparent white;
	left: -10px;
}
.ideas-vote-popup .gris {
	border-color: transparent #CCCCCC;
	left: -11px;
}

.ideas-vote-popup {
    padding: 6px;
}

.ideas-vote-popup a {
	
}

.ideas-vote-popup a.checked {
	background: #0054A7;
	border-color: #0054A7;
	color: white;
	cursor: default;
}

/*
 * Sidebar
 */
#votesLeft {
	background: #FF9900;
	color: white;
	font-size: 1.4em;
	font-weight: bold;
	margin: 0 -10px 10px;
	padding-bottom: 7px;
}
#votesLeft.zero {
	background: #999;
}
#votesLeft strong {
	font-size: 3em;
}
.sidebar-idea-list {
	margin-top: 10px;
}
.sidebar-idea-list .elgg-item-idea {
	min-height: 0px;
}
.sidebar-idea-list .elgg-item-idea > div {
	color: #666666;
	float: left;
	font-weight: bold;
	padding: 2px 6px;
}
.sidebar-idea-list .elgg-item-idea > h3 {
	padding-top: 2px;
}
.sidebar-idea-list .elgg-item-idea > div.planned {
	border-bottom: 4px solid #FFED00;
}
.sidebar-idea-list .elgg-item-idea > div.under_review {
	border-bottom: 4px solid #BBB;
}
.sidebar-idea-list .elgg-item-idea > div.started {
	border-bottom: 4px solid #89C23C;
}
.sidebar-idea-list .elgg-item-idea > div.completed {
	border-bottom: 4px solid #4690D6;
}
.sidebar-idea-list .elgg-item-idea > div.declined {
	border-bottom: 4px solid #F33;
}

.sidebar-idea-list .sidebar-idea-points {
    border: 1px solid #DEDEDE;
    border-radius: 5px;
    padding: 4px;
    text-align: center;
    background-color: #fff;
    float: left;
}

.sidebar-idea-list .sidebar-idea-title {
    float: left;
    width: 125px;
}

/*
 * Add form editidea
 */
.elgg-form-ideas-editidea .elgg-horizontal li {
	display: inline-block;
	margin-right: 5px;
	padding: 3px 10px;
}

/*
 * Group Module
 */
.module-idea-list > li {
	min-height: 48px;
}
.module-idea-list .idea-points {
	padding: 8px 0px 9px;
}

/*
 * Widgets
 */
.elgg-widget-content .points {
	font-weight: bold;
	color: #FF9900;
	font-size: 1.1em;
}
.elgg-widget-content .points.zero {
	color: #999;
}
