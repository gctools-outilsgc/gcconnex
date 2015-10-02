HTML Email Handler
==================

[![Build Status](https://scrutinizer-ci.com/g/ColdTrick/html_email_handler/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ColdTrick/html_email_handler/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/coldtrick/html_email_handler/v/stable.svg)](https://packagist.org/packages/coldtrick/html_email_handler)
[![License](https://poser.pugx.org/coldtrick/html_email_handler/license.svg)](https://packagist.org/packages/coldtrick/html_email_handler)

Send out full HTML mails to your users

Features
--------

- Send out full HTML notifications to your users (also supported by webmail like GMail)
	- can be toggle in the admin settings
	- to customise it for your own theme overrule the view default/html_email_handler/notification/body.php
- Offers mail function for developers html_email_handler_send_email()
	- see /lib/functions.php for more information
- Offers CSS conversion to inline CSS (needed for webmail support) html_email_handler_css_inliner($html_text)
	- see lib/functions.php for more information
- Allows file attachments support in notify_user (see File attachments support below)

### Administrators, Developers & Designers
If you have the **[developers][developers_url]** plugin enabled you can easily design the layout of your HTML message, check the Theming sandbox. <br />
Otherwise you can go to [the test url][test_url] to design the layout.

Conflicts
---------

As this plugin offers some of the same functionality as other plugins their may be a conflict.
Please check if you have one (or more) of the following

- [phpmailer][phpmailer_url]
- [html_mail][html_mail_url]
- [mail_queue][mail_queue_url]

[developers_url]: /admin/plugins#developers
[test_url]: /html_email_handler/test
[phpmailer_url]: http://community.elgg.org/plugins/384769/1.0/phpmailer
[html_mail_url]: http://community.elgg.org/plugins/566028/v1.0/html-mails
[mail_queue_url]: http://community.elgg.org/plugins/616834/1.1/mail-queue


File attachements notes and documentation
-----------------------------------------

File attachments support : 

If you wish to add file attachments to email notifications, you can use the notify_user function and pass it an "attachments" key, with ```$params['attachments']``` :
```php
	$attachments[] = array(
		'content' => $file_content, // File content
		//'filepath' => $file_content, // Alternate file path for file content retrieval
		'filename' => $file_content, // Attachment file name
		'mimetype' => $file_content, // MIME type of attachment
	);
```
Note that ```$attachments``` is an array, so you can pass several files at once, each with a custom filename and MIME type.

**Warning**: don't use 'filepath' setting on a production site (not functional yet)
