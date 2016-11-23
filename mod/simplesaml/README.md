SimpleSAML
==========

[![Build Status](https://scrutinizer-ci.com/g/ColdTrick/simplesaml/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ColdTrick/simplesaml/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/coldtrick/simplesaml/v/stable.svg)](https://packagist.org/packages/coldtrick/simplesaml)
[![License](https://poser.pugx.org/coldtrick/simplesaml/license.svg)](https://packagist.org/packages/coldtrick/simplesaml)

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
- Remember login  
	Set the remember me cookie so the user doesn't have to authenticate every browser session
