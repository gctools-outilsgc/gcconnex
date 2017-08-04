Analytics
=========

[![Build Status](https://scrutinizer-ci.com/g/ColdTrick/analytics/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ColdTrick/analytics/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ColdTrick/analytics/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ColdTrick/analytics/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/coldtrick/analytics/v/stable.svg)](https://packagist.org/packages/coldtrick/analytics)
[![License](https://poser.pugx.org/coldtrick/analytics/license.svg)](https://packagist.org/packages/coldtrick/analytics)

Track the usage of your site by Google Analytics and/or Piwik

Contents
--------

1. Credits
2. Important updates
3. Tracking of actions
4. Tracking of events
5. Flag admins

1. Credits
----------
**Version 1.3**

- Funding
	- Oxfam Novib for [Doenersnet][doenersnet]
- Testing and feedback
	- Jules Stuifbergen, Web Analytics Expert [http://forwardslash.nl/elgg][jules]

2. Important updates
--------------------

**Version 1.3**

- It is possible to track Actions and Events of the Elgg system.
- Tracking can be enabled in the plugin settings

**Version 2.1**

- The plugin name changed to Analytics, as we now support both [Google Analytics][google] and [Piwik][piwik] analytics tracking.

**Version 3.1**

- Updated to the [Google Universal Analytics][google] tracking.

3. Tracking of Actions
----------------------
All Actions of the Elgg system can be tracked and reported to Google Analytics as an extra pageview.
An example of an action would be /action/login if this succeeds then a pageview /action/login/success is reported to Google Analytics.
If it fails a pageview /action/login/failed will be reported to Google Analytics.

With this extra information it is possible to create and track conversions

### FOR DEVELOPERS
There is a plugin hook to prevent the tracking of actions: trigger_plugin_hook("track_action", "analytics", array("action" => $action)).
If you return false on this hook the action will not be tracked.

4. Tracking events
------------------
All events of the Elgg system can be tracked an reported to Google Analytics as an event.
An example would be the creation of an user which will be reported as _trackEvent('user', 'create', '<name>')

With this extra information it is possible to further follow the usage of your site.

### FOR DEVELOPERS
There is a plugin hook to prevent the tracking of events: trigger_plugin_hook("track_event", "analytics", array("category" => $category, "action" => $action, "label" => $label))
If you return false on this hook the action will not be tracked.

5. Flag admins
--------------
It is possible to set some extra tracking data in case of an adminitrator. This will allow you to filter the administrators out of your site usage or do other stuff.

When enabled an administrator will be flagged with a customVar 'role' which will be set to 'admin' = 1

[google]: http://www.google.com/analytics/
[piwik]: http://piwik.org/
[doenersnet]: http://www.doenersnet.nl/
[jules]: http://forwardslash.nl/elgg
