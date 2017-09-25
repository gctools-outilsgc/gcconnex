Autosubscribegroup Plugin for Elgg 1.9 - 1.12 and Elgg 2.X
==========================================================

Latest Version: 1.9.2  
Released: 2015-09-19  
Contact: iionly@gmx.de  
Website: https://github.com/iionly  
License: GNU General Public License version 2  
Copyright: (C) iionly 2012, (C) Elbee 2008


Description
-----------

This plugin allows new users to get joined to groups automatically when they register.


Installation and configuration
------------------------------

1. If you have a previous version of the Autosubscribegroup plugin installed, first remove the old autosubscribegroup plugin folder from your mod directory before copying/extracting the new version to your server,
2. Copy the autosubscribegroup plugin folder into you mod folder,
3. Enable the Autosubscribegroup plugin in the admin section of your site,
4. Define the list of groups you want new members to get joined when they register in the plugin's settings.


How to define the list of groups for autosubscribe
--------------------------------------------------

The list of groups you need to define consists of a comma separated list of the GUIDs of these groups. For example you can find out the GUID of a group when you look at the URL when you are on the group's profile page:

```
http://yoursite.url/groups/profile/<GUID>/name-of-group
```

The number that is shown in the URL (instead of `<GUID>`) is the number you need. Then simply list all the GUIDs of the groups separated by commas in the text input field on the autosubscribegroup settings page:

`<GUID1>,<GUID2>,` etc.

Press save and you are done.
