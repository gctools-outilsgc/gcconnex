<?php

$english = array(

    //
    //error messages
    //

    'contactform:Errreason'=>"<a href='#reason'><span class='prefix'>Error [#]:</span> You must choose a reason - This field is required.</a>",
    'contactform:Errsubject'=>"<a href='#subject'><span class='prefix'>Error [#]:</span> You must enter a subject - This field is required.</a>",
    'contactform:Errname'=>"<a href='#name'><span class='prefix'>Error [#]:</span> You must enter your name - This field is required.</a>",
    'contactform:Errnamebig'=>"<a href='#name'><span class='prefix'>Error [#]:</span> Name entered exceeds the limit. - Enter less than 75 characters.</a>",
    'contactform:Erremail'=>"<a href='#email'><span class='prefix'>Error [#]:</span> You must enter an email - This field is required.</a>",
    'contactform:Erremailbig'=>"<a href='#email'><span class='prefix'>Error [#]:</span> Email entered exceeds the limit. - Enter less than 100 characters.</a>",
    'contactform:Erremailvalid'=>"<a href='#email'><span class='prefix'>Error [#]:</span> You entered an invalid email. - Enter a valid email.</a>",
    'contactform:Errdepart'=>"<a href='#depart'><span class='prefix'>Error [#]:</span>  You must enter your department - This field is required.</a>",
    'contactform:Errdepartbig'=>"<a href='#depart'><span class='prefix'>Error [#]:</span>  Department entered exceeds the limit. - Enter less than 255 characters.</a>",
    'contactform:Errmess'=>"<a href='#message'><span class='prefix'>Error [#]:</span>  You must enter a message - This field is required.</a>",
    'contactform:Errmessbig'=>"<a href='#message'><span class='prefix'>Error [#]:</span> Message entered exceeds the limit. - Enter less than 2048 characters.</a>",
    'contactform:Errfiletypes'=>"<a href='#photo'><span class='prefix'>Error [#]:</span> Invalid file type. - Valid file types are: [##]</a>",
    'contactform:Errfilesize'=>"<a href='#photo'><span class='prefix'>Error [#]:</span> File size exceeds the limit. - File size should be less than [##] KB</a>",
    'contactform:Errfileup'=>"<a href='#photo'><span class='prefix'>Error [#]:</span> Error in file upload.</a>",

	'contacform' => "Contactform",
	'contactform:menu' => "Contact Us",
	'contactform:titlemsg' => "Thanks.",
	'contactform:requiredfields' => "* required fields",
	'contactform:fullname' => "Your full name",
	'contactform:email' => "Your email address",
	'contactform:phone' => "Your phone number",
	'contactform:message' => "Your message",
	'contactform:antispammsg' => "Anti-SPAM Question",
	'contactform:antispamhint' => "(Please answer the simple question below to prevent spam bots)",

	'contactform:enteremail' => "Enter the email that you want to receive feedback",
	'contactform:thankyoumsg' => "Thanks for contacting us",
	'contactform:loginreqmsg' => "Is login required to be able to use the contact form?",
	'contactform:yes' => "yes",
	'contactform:no' => "no",

	'contactform:validator:question1' => "What is the color of the sky?",
	'contactform:validator:answer1' => "blue",
	'contactform:validator:question2' => "What is the color of grass?",
	'contactform:validator:answer2' => "green",
	'contactform:validator:question3' => "What is the result of 1 + 2?",
	'contactform:validator:answer3' => "3",
	'contactform:validator:question4' => "Are you a human being?",
	'contactform:validator:answer4' => "yes",
	'contactform:validator:question5' => "Are you a SPAM robot?",
	'contactform:validator:answer5' => "no",
	'contactform:validator:name' => "Please provide your name",
	'contactform:validator:email' => "Please provide your mail address",
	'contactform:validator:emailvalid' => "Please provide a valid mail address",
	'contactform:validator:msgtoolong' => "Please provide a valid message (<2000 Characters)",
	'contactform:validator:answer' => "Please answer the Anti-SPAM question",
	'contactform:validator:failed' => "Failed the Anti-SPAM question",
);

add_translation("en", $english);
