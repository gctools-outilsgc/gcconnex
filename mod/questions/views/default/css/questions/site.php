<?php ?>

/* questions css */

.questions-checkmark {
	width: 40px;
	height: 40px;
	background:transparent url(<?php echo elgg_get_site_url(); ?>mod/questions/_graphics/checkmark.png) no-repeat;
}

.question-solution-time {
	border: 1px solid #CCC;
	padding: 0 5px;
	
	font-size: 80%;
	color: #CCC;
	
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

.question-solution-time-due {
	border-color: orange;
	color: orange;
}

.question-solution-time-late {
	border-color: red;
	color: red;
}

.question-listing-checkmark {
	background-position: 0 -126px;
}

/* end questions css*/
