Tidypics plugin for Elgg 1.10 - 1.12
====================================

Latest Version: 1.10.8  
Released: 2015-11-15  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) iionly 2013-2015, (C) Cash Costello 2011-2015


Description
-----------

The photo gallery plugin for Elgg 1.10 - 1.12.


Features
--------

- Photos organized in albums or group albums,
- Commenting on photos and albums,
- Tagging (members or word tags),
- Slideshow,
- Watermarking,
- Upload multiple photos at once (HTML5/HTML4 uploader or web form),
- Sorting photos in albums,
- RSS feeds,
- Notifications on new uploads,
- Activity (river) integration,
- Views counter,
- Exif data support,
- Userpoints support (requires Elggx Userpoints plugin),
- Various listing options (All/Mine/Friends photos, All/Mine/Friends albums, listing photos sorted by number/date of views, number/date of comments, number/date/average of ratings),
- Admin Customization: supports GD, Imagick and ImageMagick, quotas, size restrictions, and more.


Todo
----

- Get watermarking fully working (original uploaded image file gets not yet watermarked but only the resized image files),
- Add option to remove the original uploaded image after resized thumbnail images have been created,
- Replace PiclensLite slideshow with Galleria slideshow (no flash required, responsive).


Installation and configuration
------------------------------

1. If you have a previous version of the tidypics plugin installed, first disable the Tidypics plugin on your site, then remove the tidypics folder from the mod folder on your server before installing the new version!
2. Copy the tidypics plugin folder into the mod folder on your server,
3. Enable the plugin in the admin section of your site,
4. Check if there's an "Upgrade" button visible on the Tidypics plugin settings page and if yes, FIRST make a DATABASE BACKUP and then execute the upgrade.
5. Configure the plugin settings.
