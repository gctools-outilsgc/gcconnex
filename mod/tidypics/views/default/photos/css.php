<?php
/**
 * Tidypics CSS
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */
?>

.elgg-module-tidypics-album,
.elgg-module-tidypics-image {
	width: 161px;
	text-align: left;
	margin: 5px 0;
}
.elgg-module-tidypics-image {
	margin: 5px auto;
}

.tidypics-gallery-widget > li {
	width: 69px;
}
.tidypics-photo-wrapper {
	position: relative;
}

.tidypics-heading {
	color: #0054A7;
}
.tidypics-heading:hover {
	color: #0054A7;
	text-decoration: none;
}

.tidypics-input-thin {
	width: 120px;
}

#tidypics-sort li {
	width:153px;
	height:153px;
	cursor: move;
}

.tidypics-river-list > li {
	display: inline-block;
}

.tidypics-photo-item + .tidypics-photo-item {
	margin-left: 7px;
}

.tidypics-gallery > li {
	padding: 0 9px;
}

.tidypics-album-nav {
	margin: 3px 0;
	text-align: center;
	color: #aaa;
}

.tidypics-album-nav > li {
	padding: 0 3px;
}

.tidypics-album-nav > li {
	vertical-align: top;
}

.tidypics-tagging-border1 {
	border: solid 2px white;
}

.tidypics-tagging-border1, .tidypics-tagging-border2,
.tidypics-tagging-border3, .tidypics-tagging-border4 {
	filter: alpha(opacity=50);
	opacity: 0.5;
}

.tidypics-tagging-handle {
	background-color: #fff;
	border: solid 1px #000;
	filter: alpha(opacity=50);
	opacity: 0.5;
}

.tidypics-tagging-outer {
	background-color: #000;
	filter: alpha(opacity=50);
	opacity: 0.5;
}

.tidypics-tagging-help {
	position: absolute;
	left: 35%;
	top: -40px;
	width: 450px;
	margin-left: -125px;
	text-align: left;
}

.tidypics-tagging-select {
	position: absolute;
	max-width: 200px;
	text-align: left;
}

.tidypics-tag-wrapper {
	display: none;
	position: absolute;
}

.tidypics-tag {
	border: 2px solid white;
	clear: both;
}

.tidypics-tag-label {
	float: left;
	margin-top: 5px;
	color: #666;
}

#tidypics-uploader {
	position:relative;
	width:540px;
	min-height:20px;
}

#uploader {
	text-shadow: none;
}
