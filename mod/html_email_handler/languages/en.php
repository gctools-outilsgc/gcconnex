<?php 

	$english = array(
		'html_email_handler' => "HTML E-mail Handler",
		
		'html_email_handler:theme_preview:menu' => "HTML notification",
		
		// settings
		'html_email_handler:settings:notifications:description' => "When you enable this option all notifications to the users of your site will be in HTML format.",
		'html_email_handler:settings:notifications' => "Use as default e-mail notification handler",
		'html_email_handler:settings:notifications:subtext' => "This will send all outgoing e-mails as HTML mails",
		
		'html_email_handler:settings:sendmail_options' => "Additional parameters for use with sendmail (optional)",
		'html_email_handler:settings:sendmail_options:description' => "Here you can configure additional setting when using sendmail, for example -f%s (to better prevent mails being marked as spam)",
		
		// notification body
		'html_email_handler:notification:footer:settings' => "Configure your notification settings %shere%s",
		
	);

	add_translation("en", $english);
