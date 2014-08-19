upload_users
=====================

Generate new Elgg user accounts or update existing user accounts by importing a CSV file.

## Features ##

* Accepts CSV files in multiple character encodings
* Allows CSV files with various field and text delimiters
* Relies on native PHP codebase for CSV parsing
* Header mapping to arbitrary existing and new metadata names, as well as integration with profile_manager fields
* Integration with Roles
* Friendly(ie) UI

## Acknowledgements / Credits ##

* Branched from the original project by Jaakko Naakka (http://community.elgg.org/pg/plugins/release/165550/developer/naakka/upload-users)
* 1.8+ upgrades and maintenance performed by Ismayil Khayredinov for ArckInteractive

## Notes ##

1. Elgg requires that username, name, password and email be provided at the time
of user registration.
It is therefore recommended that you add these fields to your CSV. If you don't,
you will be able to specify username and name components from your CSV headers,
i.e. the import script will attempt to parse a valid username and name from a set
of details in your CSV by concatinating these strings and modifying them to match
Elgg requirements. For instance, if your CSV containts First Name and Last Name
headers, you can map the 'name' field as a sum of those two.
If omitted, passwords will be generated using Elgg's cleartext password generator.
Emails are required!

2. If you would like to assign user roles, add a column to your CSV with
the corresponding role names (that match role names defined in the Roles plugin).
You will then be offered to map your CSV header to the predefined profile
field that denotes roles.

3. If you need to attach custom processing logic to a certain CSV column,
hook to ```'header:custom_method', 'upload_users'``` and return ```true``` to
prevent metadata being created.
The callback will receive the following parameters:
```
$hook_params = array(
	'header' => $header, // original CSV header
	'metadata_name' => $metadata_name, // mapped metadata name
	'value' => $value, // metadata value (CSV cell value)
	'record' => $record, // entire mapped CSV row
	'user' => $user // Created / updated Elgg user entity
);
```


## Screenshots ##

![alt text](https://raw.github.com/arckinteractive/upload_users/master/screenshots/form.png "Form")
![alt text](https://raw.github.com/arckinteractive/upload_users/master/screenshots/mapping.png "Mapping")
![alt text](https://raw.github.com/arckinteractive/upload_users/master/screenshots/mapping_required.png "Mapping missing required fields")
![alt text](https://raw.github.com/arckinteractive/upload_users/master/screenshots/report.png "Report")