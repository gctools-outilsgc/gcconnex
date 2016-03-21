<?php

$subtypes = array(
	'hjform' => 'hjForm',
	'hjfield' => 'hjField',
	'hjfile' => 'hjFile',
	'hjfilefolder' => 'hjFileFolder',
	'hjsegment' => 'hjSegment',
	'hjannotation' => 'hjAnnotation'
);

foreach ($subtypes as $subtype => $class) {
	update_subtype('object', $subtype);
}
