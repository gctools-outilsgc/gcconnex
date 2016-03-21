<?php

return array(
	'html_email_handler' => "HTML E-mail Handler",
	
	'html_email_handler:theme_preview:menu' => "HTML notification",
	
	// settings
	'html_email_handler:settings:notifications:description' => "When you enable this option all notifications to the users of your site will be in HTML format.",
	'html_email_handler:settings:notifications' => "Use as default e-mail notification handler",
	'html_email_handler:settings:notifications:subtext' => "This will send all outgoing e-mails as HTML mails",
	'html_email_handler:settings:limit_subject' => "Limit the maximum length of e-mail subjects",
	'html_email_handler:settings:limit_subject:subtext' => "Enable this option if members are complaining about unreadable e-mail subjects (mostly Outook users). This will potentialy loose some information in the subject.",
	'html_email_handler:settings:embed_images' => "Embed images in the e-mails",
	'html_email_handler:settings:embed_images:base64' => "Base64 encoded",
	'html_email_handler:settings:embed_images:attach' => "Attachments",
	'html_email_handler:settings:embed_images:subtext' => "When enabled all images will be embedded in the e-mails. Not all e-mail clients support the different options, be sure to test the chosen option.",
	'html_email_handler:settings:proxy_host' => "Proxy host for embedding images",
	'html_email_handler:settings:proxy_port' => "Proxy port number for embedding images",
	
	'html_email_handler:settings:sendmail_options' => "Additional parameters for use with sendmail (optional)",
	'html_email_handler:settings:sendmail_options:description' => "Here you can configure additional setting when using sendmail, for example -f %s (to better prevent mails being marked as spam)",
	
	// notification body
	'html_email_handler:notification:footer:settings' => "Configure your notification settings %shere%s",
);