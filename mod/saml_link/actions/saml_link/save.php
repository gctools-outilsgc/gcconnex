<?php
// get the form inputs
$uname = get_input('username');
$email = get_input('email');

if ($uname&&$email){
  db_match_success($uname, $email);
}else{
  register_error('there was an error saving account info');
  forward(REFERER);
}

function db_match_success($user, $mail){
	$blog = new ElggObject();
	$blog->subtype = "gcpedia_account";
	$blog->title = $user;
	$blog->description = $mail;

	// for now make all my_blog posts public
	$blog->access_id = ACCESS_PUBLIC;

	// owner is logged in user
	$blog->owner_guid = elgg_get_logged_in_user_guid();

	// save tags as metadata
	$blog->tags = $tags;

	// save to database and get id of the new my_blog
	$blog_guid = $blog->save();

	// if the my_blog was saved, we want to display the new post
	// otherwise, we want to register an error and forward back to the form
	if ($blog_guid) {
      //mysql_close($gcplink);
   		system_message("Your account link was saved");
      /////////////////////////////////////////////////////
      //hardcoded address
   		forward("http://www.gcpedia.gc.ca/simplesaml/module.php/core/as_login.php?AuthId=elgg-idp&ReturnTo=http%3A%2F%2Fwww.gcpedia.gc.ca%2Findex.php%2FMain_Page");//$_SESSION["last_forward_from"]
	   //hardcoded
  } else {
   		//mysql_close($gcplink);
      register_error("The account link could not be saved");
   		forward(REFERER); // REFERER is a global variable that defines the previous page
	}
}
