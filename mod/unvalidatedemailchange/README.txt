Unvalidated Email Change plugin
Latest Version: 1.8.1
Released: 2012-06-09
Contact: iionly@gmx.de
License: GNU General Public License version 2
Copyright: (c) iionly


Requirements:

This plugin uses the elgg_register_ajax_view() function introduced with Elgg 1.8.3. Therefore you need to have at least Elgg 1.8.3 installed. You also need to have the bundled uservalidationbyemail plugin enabled and the unvalidatedemailchange plugin must be placed below it.



What this plugin does:

This plugin adds the option to change the email address of unvalidated user accounts to the Elgg core unvalidated user account administration page (menu option "Administer" - "Users" - "Unvalidated" in admin section). This option might be useful in case the email address provided when registering the account is invalid (for example only due to a typo) and therefore resending of the validation email to the orginal address is doomed to bounce. If you know the correct address for this user, you can change the email address and then resend the validation email to the new email address.



Credits:

* I had gotten used to have the email change function available with the simpleusermanagement plugin by Pjotr Savitski in Elgg 1.7 and earlier. The built-in unvalidated user administration page was a nice addition to Elgg core but I was missing the email change function. Porting the complete simpleusermanagement plugin to Elgg 1.8 would have added some redundant features, so I decided to only implement the email change option. Nonetheless, I want to thank Pjotr for the simpleusermanagement plugin that is the basis of this plugin.

* Thanks a lot also to DhrupDeScoop and Matt Beckett who helped me a lot to get the ajax-driven Lightbox popup correctly implemented.



Installation:

1. Copy the unvalidatedemailchange plugin folder into you mod folder,
2. Enable the unvalidatedemailchange plugin in the admin section of your site.


Changelog:

1.8.1:

- French translation added (thank to emanwebdev),

1.8.0:

- Initial release.
