## Read Only DB and file permissions changes for gcconnex

### File permission
This is specifically for non-cache / temp files in the data directory that stores user uploaded files, the idea is that they should no be changed or deleted but should still be viewable.

`chmod -R 544`  or `chmod -R 540`, make sure to avoid or set the temp / cache files back to their writable permissions

### Read Only Database User
The goal here is to allow gcconnex users to log in and browse but everything else is in read-only mode. For this we create a new read-only database user and only grant it enough write permissions to allow gcconnex to lo users in while using that DB user for all database connections. 
With a few caveats I'll get to below, this is the minimal set of tables that the read-only DB user would need to allow logging in browsing in gcconnex:
``` sql
grant select on elgg.* to elgg_readonly@"%" identified by "gcconnex";
grant all on elgg.elggusers_sessions to elgg_readonly@"%";
grant all on elgg.elggsystem_log to elgg_readonly@"%";
grant all on elgg.elggusers_entity to elgg_readonly@"%";
grant all on elgg.elggusers_remember_me_cookies to elgg_readonly@"%";
grant all on elgg.elggelmah_log to elgg_readonly@"%";
```
replace the wildcard in elgg_readonly@'%' with the ip of the web server if it's static

#### The Caveats
1. The very first login of a brand new users triggers some broader changes that will be blocked, but there shouldn't be new users being created in read only mode anyway, this would only impact a user that created an account before read-only mode and tries to log in for the first time after.
2. Visiting any profile triggers some changes in tables like metadata that would cause problems if writing to them is granted in this mode, this however is only done by elements added by the achievement badges and profile strength mods, disabling them allows profiles to load normally.
3. Every time a site message is loaded, it sets the "readYet" metadata flag to true, even for messages that have already been read before, this of course makes all site messages unreadable when metadata can't be changed.
Patching this in  https://github.com/gctools-outilsgc/gcconnex/blob/master/mod/wet4/pages/messages/read.php#L23 and adding a `if (!$message->readYet)` conbdition will fix this for already read messages, but for connex in read only mode it might make sense to complerely remove the update line to allow users to view all messages regardless of readYet status.
