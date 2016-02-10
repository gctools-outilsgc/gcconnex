Tidypics plugin for Elgg 1.8
Latest Version: 1.8.1beta12
Released: 2014-01-02
Contact: iionly@gmx.de
License: GNU General Public License version 2
Copyright: (c) iionly 2013-2014, (C) Cash Costello 2011-2014



This is a slightly improved version of the Tidypics plugin for Elgg 1.8.

ATTENTION:

Requires Elgg 1.8.16 at minimum! Please upgrade your Elgg installation first before upgrading the Tidypics plugin.

Currently still in beta! Most things should work. If you notice any issues, please tell me!


Known issues:

- watermarking not fully working.



Installation and configuration:

IMPORTANT: If you have a previous version of the tidypics plugin installed then disable the plugin on your site and remove the tidypics folder from the mod folder on your server before installing the new version!
1. copy the tidypics plugin folder into the mod folder on your server,
2. enable the plugin in the admin section of your site,
3. configure the plugin settings. Especially, check if there's an "Upgrade" button visible on the Tidypics plugin settings page and if yes, execute the upgrade.



Changelog:

Changes for release 1.8.1beta12 (by iionly):

- Added placeholder images to be displayed in case no images have been uploaded to an album yet in the image sizes previously missing,
- On deletion of an album the corresponding album folder in data directory gets deleted and no longer the (empty) album folder remains,
- Flash uploader fixed in the case of group albums when someone else than the album creator wants to upload images to a group album,
- Navigation arrows hidden if an album contains only a single image,
- Correction of title of group pages "Most recent albums" widget,
- "View all" link in Latest Photos widget on profile pages working for site visitors not logged in,
- Fixed list of offered existing albums to select from for image uploads when in group context,
- Fixed display of image and album gallery pages when images or albums exist that belong to groups with restricted access (The images or albums shown in the gallery pages depend on the viewing user having the necessary right for viewing depending on the access level defined for these albums including the images within these albums. For example a user gets to see all albums with "public" access level regardless if logged in or not. But if you set the access level "public" or "logged in" for a group album this results in even a non-group member being able to get access to such albums and their content. But if the group itself is a restricted group certain problems arise when this group contains "public" or "logged-in" content. In case of the gallery views within Tidypics the outcome is a fatal error occuring on these pages. This fix avoids the fatal error from happening. Still the group images and albums of restricted albums are included in the listings due to the access level set for them. If you don't want any albums or images of restricted groups to be seen by non-group-members you must set the access level of these albums to the corresponding group's level).


Changes for release 1.8.1beta11 (by iionly):
- Some general code cleanup,
- Fix of river entries appearing twice on image uploads in case the Flash uploader is used and the plugin option is set to create separate entries for each uploaded image (issue introduced in beta10),
- Added TidypicsBatch class (that extends ElggObject class) used for creation of objects of subtype "tidypics_batch" (used for handling "batches" of uploaded images) instead of creation the objects as ElggObject and assinging the subtype,
- Improvements on slideshow:
  * a slideshow can be started on all pages that display a suitable list of images (but the slideshow feature is only available if the slideshow plugin option introduced in beta10 is enabled in the plugin settings),
  * start of slideshow via title menu button,
  * slideshow will include the next 64 images (i.e. 5 pages of images) of the current displayed image list taking into account the current page offset (i.e. on page 1 the slideshow will display pages 1-5 while on page 10 it will display the images of pages 10-14 etc.). (Longtime goal for future Tidypics versions: no limitation of number of images in slideshow and most likely replacing the PicLensLite slideshow by something else / something better. Currently, the number of images to be included in a slideshow is somewhat limited by avoiding running into memory issues. Also, the PicLensLite slideshow library requires the Flash plugin on client browsers which is annoying and the 3D wall feature does no longer work),
- Improvements on image orientation correction at image uploading:
  * using best methods available depending on image library selected,
  * update orientation information saved in image file after a change of image orientation if the image library used supports this (GD library unfortunately does not support it but the exif info saved in the image file is lost on image orientation correction anyway),
  * support of orientation correction not only of rotated but also of mirrowed (and possibly additionally rotated) images,
  * some remarks regarding which image library to use for Tidypics:
    - if possible and available on your server use the "ImageMagick executable". Generally, this library has a much smaller memory requirement compared to the GD library both for image resizing (i.e. creation of thumbnail preview images) and orientation correction of images. Additionally, the exif information saved in an image file will be preserved both during resizing and orientation correction processing,
    - next best choice after "ImageMagick executable" is the "imagick PHP extension". It also has a low memory consumption compared to the GD library but you might lose exif information during image processing,
    - the GD library should be available on any server (as Elgg core requires it anyway). The memory requirement of the GD library can be quite high both for creation of thumbnails and image orientation corrections. The memory requirement is depending not on the image file size in the first place but on image resolution, color depth per pixel and color channels per pixel (so even a small sized image file might require more memory than available on the server). If you use the GD library for Tidypics on your server, your users might not be able to upload larger images. Additionaly, exif information saved in the image files might get lost during image orientation correction.


Changes for release 1.8.1beta10 (by iionly):
- Some preparations for compatibility with Elgg 1.9 (though I will release a separate version of Tidypics for Elgg 1.9!),
- Replacement of a deprecated function,
- Small improvement in Flash uploader error handling,
- New plugin option: use of slideshow optional,
- Fixed check of memory requirement for image re-sizing on upload when using GD php extension,
- Slightly better catching of missing images / thumbnail situations,
- Improved image orientation correction on image upload. When using GD library it will only be done when memory requirement is fullfilled. Additionally, Imagick php extension or ImageMagick library is used when defined as image library in Tidypics plugin settings,
- New tab on Tidypics plugin settings: image deletion by providing GUID of image (in case the image entry can't be deleted via site front-end),
- Includes the following changes in Tidypics from official Tidypics repo at https://github.com/cash/Tidypics:
  * correction of text in notifications about image uploads in case the uploader is not the owner of the album (by Jerome Bakker).


Changes for release 1.8.1beta9 (by iionly):
- Fixed php syntax error introduced in beta8 preventing group profile pages to be rendered (thanks to Pasley70 for reporting).


Changes for release 1.8.1beta8 (by iionly):
- Requires Elgg 1.8.16 due to bugfix https://github.com/Elgg/Elgg/issues/5564 for the pagination on list pages to work,
- Pagination support for the list pages (like "Most views" / "Recently commented" etc.) to show more than only a hardcoded number of photos in each list view,
- List pages (like "Most views" / "Recently commented" etc.) to work correctly when logged out and to show only photos that the viewer is allowed to see based on access level settings,
- "All", "Friends", "Mine" tabs hidden on "All photos" page when logged-out,
- "Upload photos" button hidden when logged-out,
- "Photos you are tagged in" sidebar entry hidden when logged-out,
- "Tag" entity menu entry hidden when logged out,
- "Photos you are tagged in" page revised,
- List of members tagged in a image in sidebar when viewing an image (by including a code snippet of the Tagged People plugin by Kevin Jardine),
- Fix in image and album save actions for deleting all image/album tags to work (referring to the usual Elgg Entity tags),
- Improvements in handling Tidypics user and word tags of images (including CSS improvements) to play well together with the image entity tags (avoiding double tags to be added, removal of corresponding image entity tags when an Tidypics image word tag is removed),
- River entry on adding word tags to an image,
- Includes the following changes in Tidypics from official Tidypics repo at https://github.com/cash/Tidypics:
  * made the albums notifications overridable rather than calling object_notifications() directly (by Cash Costello),
  * fixed: security issue with showing malicious exif data (by Jerome Bakker).


Changes for release 1.8.1beta7 (by iionly):
- auto-correction of image orientation on image upload (thanks to Jimmy Coder for the code snippet for image rotation),
- word tags (as opposed to tagging a user): tags that don't correspond with a username will be added to the tags of the photo (searchable),
- Includes the following changes in Tidypics from official Tidypics repo at https://github.com/cash/Tidypics:
  * set tiny size for sites that may not have it set (e.g. possibly sites updated from Elgg 1.6) (by Cash Costello),
  * stripping non word characters from title when pulled from image filename (by Cash Costello),
  * added tagging to river with notification to user (by Cash Costello, Kevin Jardine).


Changes for release 1.8.1beta6 (by iionly):
- Fix for Tidypics to work in Elgg 1.8.15 (creating new albums),
- Updated uploadify flash uploader to version 3.2 (this might only be a preliminary solution as I might need to switch to another flash (html5) uploader as the Uploadify uploader has some limitations and also seems no longer fully supported),
- Fixed some deprecated function calls (they were not in actively used code but some people might have wondered about it nonetheless as the Code Analyzer plugin gave some warnings about them),
- Fixed html code in widgets' content.php for better theme compatibility (as suggested by ura soul).


Changes for release 1.8.1beta5 (by iionly):
- Fix in river entry creation (hopefully last fix necessary for now...).


Changes for release 1.8.1beta4 (by iionly):
- River entries code reworked (solution introduced in beta3 did not work as intended),
- Option to include preview images in river entries when comments were made on albums and images,
- Fix a few errors in language files (en and de),
- Permission handling of tidypics_batches: on permission change of an album the permissions of corresponding tidypics_batches are changed to same new permission.


Changes for release 1.8.1beta3 (by iionly):
- River entries fixed (note: commenting on existing "batch" river entries does not work. It will only work for river entries created after upgrading to 1.8.1beta3!)


Changes for release 1.8.1beta2 (by iionly):
- Fixed quota support,
- Fixed issue with image entries (without images available) getting created on failed image uploads,
- Fixed an issue introduced in beta1 that resulted in (harmless but many) log entries getting created,
- Fixed Highest vote counts page,
- Display of Elggx Fivestar rating widget defined via Elggx Fivestar default view (requires version 1.8.3 of Elggx Fivestar plugin).


Changes for release 1.8.1beta1 (by iionly):
- removal of option to set access level for images. Images always get the same access level as the album they are uploaded to. On changing the access level of an album all its images get assigned the same access level, too.
- new plugin navigation / pages: more centered on (recent) images than albums,
- support of Widget Manager index page and groups' pages widgets,
- Elggx Fivestar voting widget included on detailed image views,
- some code-cleanup.


Changes since 1.8.0 Release Candidate 1:
- Pull requests made on github included. These PR were made by
   * Cash Costello
   * Brett Profitt
   * Kevin Kardine
   * Sem (sembrestels)
   * Steve Clay
   * Luciano Lima
