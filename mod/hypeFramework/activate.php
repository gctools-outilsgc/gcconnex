<?php

/** @todo: remove hjForm & hjField */
$subtypes = array(
	'hjform' => 'hjForm',  // form class
	'hjfield' => 'hjField', // form fields class
	'hjfile' => 'hjFile', // file class extention
	'hjfilefolder' => 'hjFileFolder', // fill folder class
	'hjsegment' => 'hjSegment', // content segment class
	'hjannotation' => 'hjAnnotation', // annotation class
	'hjcategory' => 'hjCategory'
);

foreach ($subtypes as $subtype => $class) {
	if (get_subtype_id('object', $subtype)) {
		update_subtype('object', $subtype, $class);
	} else {
		add_subtype('object', $subtype, $class);
	}
}

