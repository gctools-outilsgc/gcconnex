Advanced Notifications
======================

This plugin changes the way Elgg handles some notifications, it doesn't change the content of the notification or who gets it.

Features
-----------

- Offloading of notifications, so the acting user isn't affected by the amount of sent notifications
- Small speed improvement of the Messages plugin
- Optionally replace site notifications with a personalized river view
- Some extra plugin hooks for developers (see next section)

Added functionality
----------------------
### Change recipients
Plugin hook on: "interested_users:options" "notify:[method]"

Parameters:

- annotation (optional): the annotation for which this notification is sent
- entity: the entity for which this notification is sent
- options: the default options to get the interested_users
- method: the notification method currently used

Result:
The options array to be passed on to elgg_get_entities_from_relationship

### Change the message body (existing functionality)
Plugin hook on: "notify:entity:message" "[entity type]"  
or "notify:annotation:message" "[annotation subtype]"

Parameters:

- entity: the entity for which this notification is sent
	- or annotation: the annotation for which this notification is sent
- to_entity: the entity who will receive the notifications
- method: the notification method currently used

Result:
The contents of the notification message

### Change the message subject
Plugin hook on: "notify:entity:subject" "[entity type]"  
or "notify:annotation:subject" "[annotation subtype]"

Parameters:

- entity: the entity for which this notification is sent
	- or annotation: the annotation for which this notification is sent
- to_entity: the entity who will receive the notifications
- method: the notification method currently used

Result:
The subject of the notification message
