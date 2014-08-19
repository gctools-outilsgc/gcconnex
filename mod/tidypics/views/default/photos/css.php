<?php
/**
 * Tidypics CSS
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */
?>

/* ***************************************
	TIDYPICS
*************************************** */
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

/* ***************************************
	Tagging
*************************************** */
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

/* ***************************************
	Tagging
*************************************** */
#tidypics_uploader {
	position:relative;
	width:400px;
	min-height:20px;
}

#tidypics_choose_button {
	position:absolute;
	top:0;
	left:0;
	z-index:0;
	display:block;
	float:left;
}

#tidypics_flash_uploader {
	position:relative;
	z-index:100;
}

/* ***************************************
	AJAX UPLOADER
*************************************** */
#tidypics-uploader-steps {
	list-style: none;
}

#tidypics-uploader-steps li a {
	font-weight:bold;
}

.tidypics-choose-button-hover {
	color:#0054a7;
	text-decoration:underline;
}

.tidypics-disable {
	color:#cccccc;
}

.tidypics-disable:hover {
color:#cccccc;
text-decoration:none;
}

#tidypics-uploader {
	position:relative;
	width:400px;
	min-height:20px;
}

#tidypics-choose-button {
position:absolute;
top:0;
left:0;
z-index:0;
display:block;
float:left;
}

#tidypics-flash-uploader {
position:relative;
z-index:100;
}

.uploadify {
        position: relative;
        margin-bottom: 1em;
}
.uploadify-button {
        background-color: #FFFFFF;
        color: #4690D6;
        font-weight: bold;
        font-family: "Lucida Grande", Arial, Tahoma, Verdana, sans-serif;
        width: 100%;
}
.uploadify:hover .uploadify-button {
        background-color: #FFFFFF;
        color: #0054a7;
        font-weight: bold;
        font-family: "Lucida Grande", Arial, Tahoma, Verdana, sans-serif;
        text-decoration:underline;
        width: 100%;
}
.uploadify-button.disabled {
        background-color: #FFFFFF;
        color:#cccccc;
        font-weight: bold;
        font-family: "Lucida Grande", Arial, Tahoma, Verdana, sans-serif;
        text-decoration:none;
        width: 100%;
}
.uploadify-queue {
        margin-bottom: 1em;
}
.uploadify-queue-item {
        background-color: #F5F5F5;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        font: 11px Verdana, Geneva, sans-serif;
        margin-top: 5px;
        max-width: 350px;
        padding: 10px;
}
.uploadify-error {
        background-color: #FDE5DD !important;
}
.uploadify-queue-item .cancel a {
        background: url(<?php echo elgg_get_site_url() . "mod/tidypics/graphics/"; ?>cancel.png) 0 0 no-repeat;
        float: right;
        height: 16px;
        text-indent: -9999px;
        width: 16px;
}
.uploadify-queue-item.completed {
        background-color: #E5E5E5;
}
.uploadify-progress {
        background-color: #E5E5E5;
        margin-top: 10px;
        width: 100%;
}
.uploadify-progress-bar {
        background-color: #0099FF;
        height: 3px;
        width: 1px;
}
