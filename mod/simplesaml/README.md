SimpleSAML [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/ColdTrick/simplesaml/badges/quality-score.png?s=a48dc5fb7e9ff768373b2edfab24417435ddc1db)](https://scrutinizer-ci.com/g/ColdTrick/simplesaml/)
==========
Connect your site to a SAML/CAS IDentity Provider (IDP) as a Service Provider (SP) or configure your Elgg installation as an IDP.

Requirements
------------ 

- installation of SimpleSAMLPHP
- read the INSTALL.txt

Features
-------- 

- Act as SAML Service Provider (SP)
- Act as CAS Service Provider (SP)
- Act as SAML Identity Provider (IDP)
- Use multiple external IDP's (autodetects configured IDP's)
- Login with federated accounts
- Optionally create accounts based on federated account data
- Link existing account to multiple external accounts 
- Force authentication to an external IDP  
	All your users will be forced to login using the configured external IDP
- Automaticly create user accounts based on the information provided by the external IDP  
	This requires that the following attributes are set in the configuration of the SP
	- elgg:email => the email address of the user
	- elgg:firstname or elgg:lastname => because we need to create a displayname
	- elgg:external_id => to link the newly created account to the external account
- Automaticly link existing users based on their profile information and information from the IDP  
	This requires that the following attributes are set in the configuration of the SP
	- elgg:external_id => the unique ID of the user on the IDP side
	- elgg:auto_link => the value that the configured profile field must have to automaticly link the user

ToDo
---- 
- Single Logout support as SP
