Vroom for Elgg
==================
A simple way to speed up elgg. Vroom operates by flushing the output buffer before elgg shutdown begins. The browser is able to render results quickly to the user while additional shutdown functions continue on the server uninterrupted. Vroom can be used in conjunction with process intensive elgg internals such as *notifications* to create a more user-friendly atmosphere. 

## Features
 - Lightning fast elgg execution

## Server
 - Recommend PHP 5.3 or greater
 - Vroom has only been tested with Elgg v1.8.3 and probably won't work with older versions due to the fact class auto-loading was recently introduced in elgg.

## Developers

### Speed up elgg!
Vroom can help you speed up your process intensive functions that aren't rendering output to the browser. Converting old code is easy!

#### Old
```php
$var1 = "hello";
$var2 = "world";
my_slow_notifications($var1,$var2);
```
#### New
```php
$var1 = "hello";
$var2 = "world";

elgg_register_event_handler('shutdown', 'system', 
    function () use ($var1,$var2) {
           my_slow_notifications($var1,$var2);
    }
, 500);
```


### Shutdown state
Vroom sets a global `shutdown_flag` to let functions know if elgg is in shutdown mode. This can be checked easily. For example:  `isset($GLOBALS['shutdown_flag'])` 
