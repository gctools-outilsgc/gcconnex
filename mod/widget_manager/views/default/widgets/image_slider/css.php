<?php ?>

.image_slider_settings > div {
	display: none;
}

.image_slider_settings > label {
	cursor: pointer;
}

.widgets_image_slider {
	width: 100%; /* important to be same as image width */
	position: relative; /* important */
	overflow: hidden; /* important */
	float: left;
}

.widgets_image_slider_content {
	width: 100%; /* important to be same as image width or wider */
	position: absolute;
	top: 0;
	list-style-image: none !important;
}

.widgets_image_slider_image {
	float: left;
	position: relative;
	display: none;
	width: 100%;
}

.widgets_image_slider_image span {
	position: absolute;
	width: 100%;
	
	filter: alpha(opacity = 80);
	-moz-opacity: 0.8;
	-khtml-opacity: 0.8;
	opacity: 0.8;
	color: #fff;
	display: none;
}

.widgets_image_slider_image span div {
	padding: 10px 13px;
}

.widgets_image_slider_image span strong {
	font-size: 14px;
}

.widgets_image_slider_content .top {
	top: 0;
	left: 0;
}

.widgets_image_slider_content .bottom {
	bottom: 0;
	left: 0;
}

.widgets_image_slider_content .left {
	top: 0;
	left: 0;
	width: 180px !important;
}

.widgets_image_slider_content .right {
	right: 0;
	bottom: 0;
	width: 180px !important;
}