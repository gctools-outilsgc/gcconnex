<?php

$english = array(
	'machine:linktext' => 'Language Comprehension Tool', //text displayed when hovering over the icon
	'machine:setting:url' => 'Machine Translation URL', //back end admin panel field for inputing LC tool api service url //not essential
	'mc:LCtool:title' => 'Language Comprehension Tool',	//Modal(popup window) title field
	//following is the disclaimer text on modal window. Taken from LC tool terms of use
	'mc:LCtool:disclaimerTitle' => "<h3>Important:</h3>",
	'mc:LCtool:disclaimer1' => "<p>The <a href='https://outilcl-lctool.spac-pspc.gc.ca/index-eng.php'>Language Comprehension Tool</a> provides a general idea of a text's content and does not replace professional language services. The Translation Bureau recommends using this tool for the purposes of improving the understanding of short, simple and unofficial communications in your second language.</p>",
	'mc:LCtool:disclaimer2' => "<p>To obtain professional translation and revision services, <a href='https://order.translationbureau.gc.ca/gctranslation/app/pages/session/login?lang=en'>submit a request online</a>.</p>",
	'mc:LCtool:disclaimer3' => "<p>Do not hesitate to send us your <a href='https://outilcl-lctool.spac-pspc.gc.ca/suggestions-eng.php'>comments</a> on the Language Comprehension Tool.</p>",
	'mc:LCtool:button' => 'Process', //replaces "translate" button text. Function: sends text to LC tool service from translation
	'mc:button:cancel' => 'Cancel', //closes window
	'mc:button:ok' => 'Replace', // button places translated text into dom. Replaces original text for the viewer
	'mc:LCtool:originalText' => 'Original Text:', //header above text box comtaining original text
	'mc:LCtool:wait' => 'Please wait...', //replaces 'mc:LCtool:originalText' while loading spinner is active
	'mc:LCtool:translated' => 'Translated Text:', // replaces 'mc:LCtool:wait' once translation has been recived from service and displayed for user.
);

add_translation('en', $english);
