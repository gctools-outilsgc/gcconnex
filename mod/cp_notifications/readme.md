Notifications
=============

As per the Requirements document for the Notification revampment, Notifications for GCconnex are more refined which allows users to "subscribe" or "unsubscribe" particular content (ie Discussion Topics, Blogs, Forums, etc)

Instructions (How to Use)
=========================
* Setting the email address (From field, Reply-To, etc) can be set in the Administration Panel
* Allow user to op-out of the mass enablement of notifications for everything
* Allow user to minor edit their content
* Display the quick links sidebar for easy access to their notifications


Plugins modified with hook triggers (file locations)
========================================================

|[ # ]  | [Plugin Names/ID]       | [ Filepaths ]                                                          |
|:-----:|:-----------------------:|-----------------------------------------------------------------------:|
| ===== | ======================= | =======================================================================|
| 1.    |**Mentions** 	       	  |- mentions/start.php 												   |
| 2.    |**Group Operators** 	  |- group_operators/actions/group_operators/add.php 					   |
| 3.    |**Group Tools**		  |- group_tools/lib/functions.php 										   |
| 4.    |**Wire Tools** 		  |- thewire_tools/lib/events.php 										   |
| 5.    |**CP Notifications** 	  |- cp_notifications/actions/useradd.php (overwrites core action) 		   |
| 6.    |**Invite Friends**		  |- invitefriends/actions/invite.php 									   |
| 7.    |**Friend Request**		  |- friend_request/actions/approve.php       							   |
| 8.    |**Messages** 			  |- messages/actions/messages/send.php 								   |
| 9.    |**Group Tools**		  |- group_tools/lib/functions.php (see #3 & start.php) 				   |
| 10.   |**Group Tools**		  |- group_tools/lib/functions.php (see #3, #9 & start.php)				   |
| 11.   |**Group Tools**		  |- group_tools/actions/mail.php 										   |
| 12.   |**Friend Request**		  |- friend_request/lib/events.php 										   |
| 13.   |**Validation by Email**  |- uservalidationbyemail/lib/functions.php 							   |
| 14.   |**GCforums**			  |- gcforums/actions/gcforums/create.php 								   |
| 15.   |**Event Calendar**		  |- event_calendar/actions/event_calendar/add_personal.php 			   |
| 	    |						  |- event_calendar/actions/event_carlendar/delete.php 					   |
|	    |						  |- event_calendar/actions/event_carlendar/edit.php 					   |
| 	    |						  |- event_calendar/actions/event_carlendar/remove_personal.php 		   |
| 16.   |**GCforums**			  |- gcforums/actions/gcforums.create.php 								   |
| 17.	|**Message Board**		  |- messageboard/actions/add.php 										   |
| 18.	|**The Wire Tools**		  |- thewire_tools/actions/add.php


Plugins modified to allow auto-subscription (file locations)
============================================================
1. .../mod/groups/actions/groups/membership/join.php
2. .../actions/save.php
3. .../mod/groups/actions/groups/join.php
4. .../mod/group_tools/actions/groups/edit.php
5. .../mod/group_tools/actions/groups/invite.php
6. .../mod/groups/actions/groups/edit.php


Plugins modified to implement Minor Edit (file locations)
=========================================================
1. .../mod/wet4/views/default/forms/pages/edit.php
2. .../mod/wet4/views/default/forms/polls/edit.php
3. .../mod/wet4/views/default/forms/event_calendar/edit.php
4. .../mod/tasks/views/default/forms/tasks/edit.php

5. .../mod/pages/actions/pages/edit.php
6. .../mod/event_calendar/actions/event_calendar/edit.php
7. .../mod/polls/actions/polls/actions/polls/edit.php
8. .../mod/tasks/actions/tasks/edit.php 

9. .../mod/groups/actions/groups/membership/add.php
10. .../mod/groups/actions/groups/membership/join.php
11. .../mod/groups/actions/groups/edit.php
12. .../mod/group_tools/actions/groups/edit.php
13. .../mod/group_tools/actions/groups/invite.php
14. .../mod/pages/actions/pages/edit.php
15. .../mod/pages/page/pages/new.php
16. .../mod/tasks/actions/tasks/edit.php
17. .../mod/tasks/views/default/forms/tasks/edit.php
18. .../mod/wet4/views/default/forms/event_calendar/edit.php
19. .../mod/wet4/views/default/forms/pages/edit.php

Update since May 28 2016
20. .../mod/cp_notifications/actions/cp_notifications/user_autosubscription.php
21. .../mod/cp_notifications/languages/*.php
22. .../mod/cp_notifications/views/default/plugins/cp_notifications/usersettings.php
23. .../mod/groups/actions/groups/membership/leave.php
24. .../mod/groups/actions/groups/membership/remove.php


