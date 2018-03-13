<?php
$en = array(
    "admin:server:pleio_template:env" => "Environment",
    "pleio_template:type" => "Type",
    "pleio_template:send_mail" => "Send mail",
    "admin:users:access_requests" => "Access requests",
    "admin:users:import" => "Import users",
    "pleio:site_permission" => "Permission of the site:",
    "pleio:not_configured" => "The Pleio login plugin is not configured.",
    "pleio:registration_disabled" => "Registration is disabled, create an account on Pleio.",
    "pleio:walled_garden" => "Welcome to %s",
    "pleio:walled_garden_description" => "Access to this site is restricted to users. Log in to access the site or request membership.",
    "pleio:request_access" => "Request access",
    "pleio:request_access:description" => "To enter this site, you must request access from the admin. Click the button to request access.",
    "pleio:validate_access" => "Validate access",
    "pleio:validate_access:description" => "Your email domain is whitelisted for this website. Please check your details and request access. We will send you an e-mail with a link that provides direct access to the site.",
    "pleio:validate_access:error" => "Something went wrong during validation. Please try again",
    "pleio:change_settings" => "Change settings",
    "pleio:change_settings:description" => "To change your settings please go to %s. After you changed the settings, please login again to effectuate your settings.",
    "pleio:access_requested" => "Requested access",
    "pleio:could_not_find" => "Could not find access request.",
    "pleio:access_requested:wait_for_approval" => "Access is requested. You will receive an e-mail when the request is accepted.",
    "pleio:access_requested:check_email" => "Check your e-mail and follow the link to activate your account.",
    "pleio:no_requests" => "Currently there are no requests.",
    "pleio:approve" => "Approve",
    "pleio:decline" => "Decline",
    "pleio:settings:notifications_for_access_request" => "Send all admins a notification when somebody requests access to the site",
    "pleio:admin:access_request:subject" => "New access request for %s",
    "pleio:admin:access_request:body" => "Hello %s,
        Somebody with the name %s has performed an access request to %s.
        To review the request please visit:

        %s",
    "pleio:approved:subject" => "You are now member of: %s",
    "pleio:approved:body" => "Hello %s,

    The administrator approved your access request to %s. Go to this link to get access to the site:

    %s",
    "pleio:declined:subject" => "Membership request declined for: %s",
    "pleio:declined:body" => "Hello %s,

Unfortunately the site administrator of %s decided to decline your membership request. Please contact the administrator if you think this is a mistake.",
    "pleio:closed" => "Closed",
    "pleio:open" => "Open",
    "pleio:settings:email_from" => "When not configured, all mail is send from %s.",
    "pleio:settings:authorization" => "Authorization",
    "pleio:settings:auth" => "Authorization Type",
    "pleio:settings:oauth" => "OAuth2",
    "pleio:settings:oidc" => "OpenID Connect",
    "pleio:settings:auth_url" => "Auth issuer URL",
    "pleio:settings:auth_client" => "Client ID",
    "pleio:settings:auth_secret" => "Client Secret",
    "pleio:settings:idp" => "SAML2 Identity Provider",
    "pleio:settings:idp_id" => "When using SAML2 login, provide the unique ID of the SAML2 Identity Provider",
    "pleio:settings:idp_name" => "Identity Provider display name",
    "pleio:settings:additional_settings" => "Additional Settings",
    "pleio:settings:login_through" => "Login through %s",
    "pleio:settings:login_credentials" => "Allow to login with credentials as well",
    "pleio:settings:walled_garden_description" => "Description on login page of closed site",
    "pleio:login_with_credentials" => "Or, login using credentials",
    "pleio:is_banned" => "Unfortunately, your account is banned. Please contact the site administrator.",
    "pleio:imported" => "Imported %s users, updated %s users and an error occured while importing for %s users.",
    "pleio:users_import:step1:description" => "This functionality allows you to import users using a CSV file. Please choose the CSV file in the first step. Make sure the first line of the CSV contains the field names and the fields are delimited by a semicolon ;. The permissionlevel of the fields will be set to the default site level. Please make sure the CSV is encoded with UTF-8.",
    "pleio:users_import:step2:description" => "Please link the source fields in the CSV file to the target fields in this platform. Make sure that users within the platform are ",
    "pleio:users_import:choose_field" => "Choose a field",
    "pleio:users_import:source_field" => "Source field",
    "pleio:users_import:target_field" => "Target field",
    "pleio:users_import:step1:file" => "CSV file",
    "pleio:users_import:step1:file" => "Continue to the next step",
    "pleio:users_import:step1:success" => "CSV is uploaded succesfully",
    "pleio:users_import:step1:error" => "There was an error while uploading the CSV file. Please check the file and try again.",
    "pleio:users_import:sample" => "sample",
    "pleio:users_import:started_in_background" => "Import started in the background. You will receive an e-mail after completion.",
    "pleio:users_import:email:success:subject" => "Import was a success",
    "pleio:users_import:email:success:body" => "Dear %s,

    The import of users succeeded. Here are the stats:

    %s users added
    %s users updated
    %s users failed
    ",
    "pleio:users_import:email:failed:subject" => "Import failed",
    "pleio:users_import:email:failed:body" => "Dear %s,

    The import of users failed. Here is the error message of the server:

    %s
    ",
    "profile:gender" => "Gender",
    "pleio:settings:domain_whitelist" => "Domain whitelist",
    "pleio:settings:domain_whitelist:explanation" => "You can enter a comma-seperated list of domains, e.g. example.com, example2.com",
    "pleio:validation_email:subject" => "Please validate your account for %s",
    "pleio:validation_email:body" => "Hello %s,

    You requested access to %s. Please follow this link to get direct access:

    %s",
    "pleio:no_token_available" => "No token available. Please try to login again."
);

add_translation("en", $en);