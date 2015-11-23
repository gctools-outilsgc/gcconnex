<?php

$english = array(

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
    'contactform:select' => 'Please select a reason',
    'contactform:reason' => 'Select...',
    //setting page
    
    'setting:delete' => 'Delete',
    'setting:add' => 'Add',
    'setting:id' => 'ID',
    'setting:eng' => 'English',
    'setting:fr' => 'French',
    'setting:field' => 'New question',
    
    //FAQ 
    
      'contactform:help_menu_item' => "Help / Contact Us",
    'contactform:body' => "<div class='elgg-output'>

				<h2 style='border-bottom: solid 3px; padding-bottom: 2px;'>Help</h2>
					<br />
					<h3><u>GCconnex Help Pages</u></h3><br />
						<ul>
						<li> <a href='http://gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0'>How-Tos/Videos/Tutorials</a> </li>
						<li> <a href='http://gcconnex.gc.ca/file/view/6133688/intro-to-gcconnex-learn-the-how-to-in-6-easy-steps-and-start-using-gcconnex-today'>6 Steps to Using GCconnex</a> </li>
						<li> <a href='http://gcconnex.gc.ca/file/view/390515/en-managing-your-email-notifications-on-gcconnexpdf'>Managing Email Notifications</a> </li>
						</ul><br />

					<h3><u>FAQ</u></h3><br />
						<h4>Lost Password:</h4>
						To recover your <b>GCconnex Password</b>, go to the <a href='http://gcconnex.gc.ca/'>GCconnex main page</a> or access the <b>Log in</b> pop-up found in the upper left corner of every GCconnex page. Follow the <b>Lost password</b> link and enter your username or email address, then click <b>Request</b>. A link to reset your password will be sent to email address you associated with your GCconnex account. Follow this link, and then click <b>Reset password</b> to have a new, randomly generated password emailed to your email address. 
						<br /><br />
						Once you have logged in with the new password, follow the <b>Settings</b> link found in the upper right corner of every GCconnex page. Under the <b>Account password</b> heading, enter your <b>Current password</b> (the randomly generated password which has been emailed to you) and <b>Your new password</b> (the password you would like to use going forward) twice, then click <b>Save</b>.
						<br /><br />
						
						<h4>Lost Username:</h4>
						If you have forgotten your <b>GCconnex Username</b>, don't worry; it is not necessary to recover it. You can use your GCconnex-associated email address to login to GCconnex, either on the <a href='http://gcconnex.gc.ca/'>GCconnex main page</a> or the Log in pop-up found in the upper left hand corner of every GCconnex page. 
						<br /><br />
						However, if your email has changed since you signed up for GCconnex, you cannot use the new one to login unless you have <a href='http://gcconnex.gc.ca/settings/'>updated your email in your settings</a>. Please email <a href='mailto:gcconnex@tbs-sct.gc.ca'>gcconnex@tbs-sct.gc.ca</a> and note that you no longer have access to your GCconnex- associated email address. We will get back to you within two business days. 
						<br /><br />
						
						<h4>Create Account:</h4>
						Go to <a href='http://gcconnex.gc.ca/'>GCconnex.gc.ca</a> and click \"Register\" (below \"Log in\"). You can then enter your work email address and choose a password. Then read and accept the Terms and Conditions and click \"Register\". 
						<br /><br />
						
						<h4>Upload Profile Picture:</h4>
						Click on the Profile icon in the top left corner (it will either look like your current profile picture or the default silhouette). You will be directed to a new page that you can then click \"Edit Avatar\". Then click \"Browse\" and select the picture you would like to use and press \"Upload\". You can then crop your picture (if necessary) using the preview section.
						<br /><br />

					<h3><u>GCconnex Groups that may be useful to you:</u></h3><br />
						<ul>
						<li> <a href='http://gcconnex.gc.ca/groups/profile/211647/clicks-and-tips'>Clicks and Tips</a> </li>
						<li> <a href='http://gcconnex.gc.ca/groups/profile/226392/gc20-tools-outils-gc20'>GC2.0 Tools</a> </li>
						</ul>

				<h2 style='border-bottom: solid 3px; padding-bottom: 2px;'>Contact Us</h2>
					<p style = 'padding: 8px 0 8px'>
					Can't find the answer you're looking for in the FAQ or help resources? <br /> <br />
					<b>Contact the GCconnex <a href='mailto:gcconnex@tbs-sct.gc.ca'>Help Desk</a>!</b> Please be as clear as possible in describing your issue or question, and provide screen shots if and where possible.
					</p> <br />

						</div>"
);

add_translation("en", $english);
