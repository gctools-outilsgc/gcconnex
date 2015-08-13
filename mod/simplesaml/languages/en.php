<?php

$english = array(
	// general stuff
	'simplesaml:error:loggedin' => "This action can't be performed when you're logged in",
	'simplesaml:error:no_source' => "No authentication source defined",
	'simplesaml:error:source_not_enabled' => "The provided authentication source isn't enabled on this site",
	'simplesaml:error:source_mismatch' => "The provided authentication source doesn't match the server connection",
	'simplesaml:error:class' => "Error while getting the authentication source configuration: %s",
	
	'simplesaml:source:type:unknown' => "Unknown",
	'simplesaml:source:type:saml' => "SAML",
	'simplesaml:source:type:cas' => "CAS",
	
	// pages
	// no linked account
	'simplesaml:no_linked_account:title' => "No account linked to the authentication source: %s",
	'simplesaml:no_linked_account:description' => "We couldn't find an account which is linked to your external account of %s. You can link your site account with your external account when you login or register below.",
	
	'simplesaml:forms:register:description' => "If you don't have an account on this site yet, you can register an account by clicking on the register button. It may be neccesary to provide some additional information.",
	
	'simplesaml:no_linked_account:login' => "Click here if you already have an account on this site",
	
	// settings
	'simplesaml:settings:simplesamlphp_path' => "Path to the SimpleSAMLPHP library",
	'simplesaml:settings:simplesamlphp_path:description' => "The full path to the SimpleSAMLPHP (http://simplesamlphp.org) library without a trailing slash (/)",
	'simplesaml:settings:simplesamlphp_directory' => "Virtual directory of the SimpleSAMLPHP library",
	'simplesaml:settings:simplesamlphp_directory:description' => "The directory in which the SimpleSAMLPHP library is located without a trailing slash(/). For example if the full path is %ssimplesamlphp/, please enter simplesamlphp",
	
	'simplesaml:settings:sources' => "Service provider configuration",
	'simplesaml:settings:sources:name' => "Authentication source",
	'simplesaml:settings:sources:type' => "Type",
	'simplesaml:settings:sources:allow_registration' => "Allow registration",
	'simplesaml:settings:sources:auto_create_accounts' => "Automaticly create accounts",
	'simplesaml:settings:sources:save_attributes' => "Save authentication attributes",
	'simplesaml:settings:sources:force_authentication' => "Force authentication",
	
	'simplesaml:settings:sources:configuration:title' => "Configuration settings for: %s",
	'simplesaml:settings:sources:configuration:icon' => "URL to an icon for this connection (optional)",
	'simplesaml:settings:sources:configuration:icon:description' => "You can provide an URL to an icon for this connection, it will be used on the login screen and the user settings page.",
	'simplesaml:settings:sources:configuration:external_id' => "Field with the unique user id from the SAML connection (optional)",
	'simplesaml:settings:sources:configuration:external_id:description' => "If you can't get the unique user id from the attributes, you can provide a field from the AuthData which contains the user id",
	'simplesaml:settings:sources:configuration:auto_link' => "Automaticly link existing accounts based on profile information (optional)",
	'simplesaml:settings:sources:configuration:auto_link:description' => "If the external authentication source provides the configured profile information, both accounts will be linked automaticly.",
	'simplesaml:settings:sources:configuration:auto_link:none' => "Don't allow automatic linking",
	
	'simplesaml:settings:warning:configuration:sources' => "No authentication sources have been configured yet",
	'simplesaml:settings:warning:configuration:simplesamlphp' => "Please provide the path to the SimpleSAMLPHP library for further configuration options",
	
	'simplesaml:settings:idp' => "IDentity Provider configuration for: %s",
	'simplesaml:settings:idp:description' => "Here you can configure which profile information is provided in the SAML authentication process.",
	'simplesaml:settings:idp:show_attributes' => "Show the configurable profile information fields",
	'simplesaml:settings:idp:profile_field' => "Profile field",
	'simplesaml:settings:idp:attribute' => "SAML attribute name",
	'simplesaml:settings:idp:attribute:description' => "When an attribute name is left blank it will not be provided in the SAML authentication process.",
	
	// user settings
	'simplesaml:usersettings:connected' => "Your account is connected with the external authentication source %s. You can login to this site with you external account if you wish.",
	'simplesaml:usersettings:unlink_url' => "Click here to remove the connection",
	'simplesaml:usersettings:unlink_confirm' => "Are you sure you wish to break the connection with %s",
	
	'simplesaml:usersettings:toggle_attributes' => "Show the saved authentication attributes",
	'simplesaml:usersettings:attributes:name' => "Name",
	'simplesaml:usersettings:attributes:value' => "Value",
	
	'simplesaml:usersettings:not_connected' => "Your account is not connected with the external authentication source %s. If you wish to login on this site with your external account, please link both account.",
	'simplesaml:usersettings:link_url' => "Click here to link both accounts",
	
	'simplesaml:usersettings:no_sources' => "No external authentication sources are available, please ask your administrator to configure this.",
	
	// widgets
	'simplesaml:widget:description' => "Shows a login widget with only external authentication sources",
	'simplesaml:widget:select_source' => "Please select the authentication source to show in the widget",
	'simplesaml:widget:logged_in' => "<b>%s</b> welcome on the <b>%s</b> community",

	// procedures
	// login
	'simplesaml:login:no_linked_account' => "No account is connected to the authentication source %s",
	
	// authorize
	'simplesaml:authorize:error:attributes' => "No attributes could be found from the authentication source %s, please try again or contact your site administrator",
	'simplesaml:authorize:error:external_id' => "No unique identifier could be found from the authentication source %s, please try again or contact your site administrator",
	'simplesaml:authorize:error:link' => "An unknown error occured while connecting with the authentication source %s",
	'simplesaml:authorize:success' => "You've successfully connected your account with the authentication source %s",
	
	// actions
	// register
	'simplesaml:action:register:error:displayname' => "No display name was provided, please fill in your name",
	
	// unlink
	'simplesaml:action:unlink:error' => "An unknown error occured while removing the link with the authentication source %s",
	'simplesaml:action:unlink:success' => "You've successfully removed the link with the authentication source %s",
	'simplesaml:login:title' => "GC2.0 Tools Log in Portal",
	'simplesaml:login:body' => "Use your GCconnex account information to log in.</br>",
	'simplesaml:login:body:other' => "Don't have a GCconnex account? Create one by clicking the \"Register\" link below.</br></br>",
);

add_translation("en", $english);
