Notification Messages
=====================
Bins all the users to respective department/domain, and "caches" them in a .json file. This is done by checking the user email domains.


Contents
--------
1. Module Dependencies
2. Installation Guide
3. Future Development
4. What's new


1. Module Dependencies
----------------------
- requires a CSV file within the data folder (labelled as /gc_dept)
- requires permission to write inside of /gc_dept


2. Installation Guide
----------------------
- place within the /mod directory and allow permission to create and write to /datafolder/gc_dept

	
3. Future Development
---------------------
- allow visibility rules (public/private/logged in)
- allow exporting tabled data to an excel spreadsheet


4. What's new
-------------
June 03 2015
- revisions and documented code (backend)
- issue with regenerating report is fixed, it does not timeout when it tries to do an update
- can only update via the administrative access
- json files has been reduced to two (it would produce 3 json files)
- Government of Canada departments have been made bilingual, users can now toggle between English and French