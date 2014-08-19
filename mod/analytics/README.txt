= Google Analytics =
As of release 1.3 it is possible to track Actions and Events of the Elgg system.
Tracking can be enabled in the plugin settings

== Contents ==
1. Credits
2. Tracking of actions
3. Tracking of events
4. Flag admins


== 1. Credits ==
=== Release 1.3 ===
Funding
- Oxfam Novib for Doenersnet (www.doenersnet.nl)

Testing and feedback
- Jules Stuifbergen, Web Analytics Expert (http://forwardslash.nl/elgg)

== 2. Tracking of Actions ==
All Actions of the Elgg system can be tracked and reported to Google Analytics as an extra pageview.
An example of an action would be /action/login if this succeeds then a pageview /action/login/success is reported to Google Analytics.
If it fails a pageview /action/login/failed will be reported to Google Analytics.

With this extra information it is possible to create and track conversions

=== FOR DEVELOPERS ===
There is a plugin hook to prevent the tracking of actions: trigger_plugin_hook("track_action", "analytics", array("action" => $action)).
If you return false on this hook the action will not be tracked.

== 3. Tracking events ==
All events of the Elgg system can be tracked an reported to Google Analytics as an event.
An example would be the creation of an user which will be reported as _trackEvent('user', 'create', '<name>')

With this extra information it is possible to further follow the usage of your site.

=== FOR DEVELOPERS ===
There is a plugin hook to prevent the tracking of events: trigger_plugin_hook("track_event", "analytics", array("category" => $category, "action" => $action, "label" => $label))
If you return false on this hook the action will not be tracked.

== 4. Flag admins ==
It is possible to set some extra tracking data in case of an adminitrator. This will allow you to filter the administrators out of your site usage or do other stuff.

When enabled an administrator will be flagged with a customVar 'role' which will be set to 'admin' = 1