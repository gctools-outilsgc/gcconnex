= HTML Email Handler =

Send out full HTML mails to your users

== Contents ==

1. Features
2. Conflicts

== 1. Features ==

- Send out full HTML notifications to your users (also supported by webmail like GMail)
	- can be toggle in the admin settings
	- to customise it for your own theme overrule the view default/html_email_handler/notification/body.php
- Offers mail function for developers html_email_handler_send_email()
	- see /lib/functions.php for more information
- Offers CSS conversion to inline CSS (needed for webmail support) html_email_handler_css_inliner($html_text)
	- see lib/functions.php for more information

=== 1.1. Administrators, Developers & Designers ===
If you have the <b><a href="/admin/plugins#developers">developers</a></b> plugin enabled you can easily design the layout of your HTML message, check the Theming sandbox. <br />
Otherwise you can go to <a href="/html_email_handler/test">/html_email_handler/test</a> to design the layout.

== 2. Conflicts ==

As this plugin offers some of the same functionality as other plugins their may be a conflict.
Please check if you have one (or more) of the following

- phpmailer (<a href="http://community.elgg.org/pg/plugins/project/384769/developer/costelloc/phpmailer" target="_blank">http://community.elgg.org/pg/plugins/project/384769/developer/costelloc/phpmailer</a>)
- html_mail (<a href="http://community.elgg.org/pg/plugins/project/566028/developer/tulicipriota/html-mails" target="_blank">http://community.elgg.org/pg/plugins/project/566028/developer/tulicipriota/html-mails</a>)
- mail_queue (<a href="http://community.elgg.org/pg/plugins/project/616834/developer/mcampo/mail-queue" target="_blank">http://community.elgg.org/pg/plugins/project/616834/developer/mcampo/mail-queue</a>)
