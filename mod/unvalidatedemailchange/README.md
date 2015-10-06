Unvalidated Email Change plugin for Elgg 1.10 - 1.12 and Elgg 2.X
=================================================================

Latest Version: 1.10.3  
Released: 2015-09-19  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) iionly


Requirements
------------

You need to have the bundled uservalidationbyemail plugin enabled and the unvalidatedemailchange plugin must be placed below it to be able to change the email addresses of unvalidated accounts. Optional is the IP Tracker plugin.


What this plugin does
---------------------

This plugin adds the option to change the email address of unvalidated user accounts to the Elgg core unvalidated user account administration page (menu option "Administer" - "Users" - "Unvalidated" in admin section). This option might be useful in case the email address provided when registering the account is invalid (for example only due to a typo) and therefore resending of the validation email to the orginal address is doomed to bounce. If you know the correct address for this user, you can change the email address and then resend the validation email to the new email address.

If you have also the IP Tracker plugin installed, you will also see the IP addresses these accounts have been registered from.


Credits
-------

* I had gotten used to have the email change function available with the simpleusermanagement plugin by Pjotr Savitski in Elgg 1.7 and earlier. The built-in unvalidated user administration page was a nice addition to Elgg core but I was missing the email change function. Porting the complete simpleusermanagement plugin to Elgg 1.8 would have added some redundant features, so I decided to only implement the email change option. Nonetheless, I want to thank Pjotr for the simpleusermanagement plugin that is the basis of this plugin.
* Thanks a lot also to DhrupDeScoop and Matt Beckett who helped me a lot to get the ajax-driven Lightbox popup correctly implemented.


Installation
------------

1. If you have a previous version of the Unvalidated Email Change plugin installed, first remove the old unvalidatedemailchange plugin folder from your mod directory before copying/extracting the new version to your server,
2. Copy the unvalidatedemailchange plugin folder into you mod folder,
3. Enable the Unvalidated Email Change plugin in the admin section of your site.
