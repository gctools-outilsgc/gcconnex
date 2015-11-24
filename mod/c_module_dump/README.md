Module Dump
=====================
Collection of patches and small enhancements for GCconnex (Government of Canada instance of Elgg)

Contents
--------
1. Module Dependencies
2. Installation Guide
3. Functionalities


1. Module Dependencies
----------------------
does not require any modules to run


2. Installation Guide
----------------------
1. put in root mod directory .../mod/ 
2. enable module

	
3. Functionalities
-------------------
+ [enhance] places a notice on every edit/add pages, to inform users that documents must not be secret
+ [issue] adds a new tab in the Tasks section, displays the tasks assigned to user 						- after tasks
+ [enhance] ??? removed avatar update and friend request in the activity feed (activity feed + widgets)
+ [enhance] inbox username will direct user to said user's pages 										- after messages
+ [issue] default number of replies to a discussion thread will be 25 that will be displayed			- after groups
+ [issue] fix to the memcache problem																	- after au_subgroups
X [issue] ??? uservalidation page within the administrative rights does not display correctly			- after uservalidationbyemail
+ [enhance] displays the last login/activity on the user profile page, under their avatar				- after profile
+ [issue] fix to the ideas widget where it displays max of 3											- after ideas


Legend
------
+ 			added/included
X 			removed/purged
[enhance] 	enhancement that are implemented
[issue]		issues that are patched 