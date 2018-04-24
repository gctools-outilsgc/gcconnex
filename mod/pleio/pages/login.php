<?php

require_once(dirname(__FILE__) . "/../vendor/autoload.php");

$auth = elgg_get_plugin_setting('auth', 'pleio');
$auth_url = elgg_get_plugin_setting('auth_url', 'pleio');
$auth_client = elgg_get_plugin_setting('auth_client', 'pleio');
$auth_secret = elgg_get_plugin_setting('auth_secret', 'pleio');

if (elgg_is_logged_in()) {
    forward("/");
}

$site = elgg_get_site_url();
$db_prefix = elgg_get_config('dbprefix');

$code = get_input("code");
$state = get_input("state");
$returnto = urldecode(get_input("returnto"));

$login_credentials = get_input("login_credentials");
$idp = elgg_get_plugin_setting("idp", "pleio");

if (!$auth || !$auth_client || !$auth_secret || !$auth_url) {
    register_error(elgg_echo("pleio:not_configured"));
    forward(REFERER);
}

if ($auth == 'oidc') {
    $oidc = new Jumbojett\OpenIDConnectClient($auth_url . 'openid', $auth_client, $auth_secret);
    $oidc->addScope(array('openid', 'profile', 'email'));

    try {
        $oidc->authenticate();
    } catch (Jumbojett\OpenIDConnectClientException $e) {
        register_error($e->getMessage());
        forward("/");
    }

    $userid = $oidc->requestUserInfo('sub');
    $name = $oidc->requestUserInfo('name');
    $email = $oidc->requestUserInfo('email');
    $username = $oidc->requestUserInfo('nickname');

    $user = get_user_by_pleio_guid_or_email($userid, $email);
    $allow_registration = elgg_get_config("allow_registration");

    if (!$user && $allow_registration) {

        /*** Username Generation ***/
        $query = "SELECT count(*) as num FROM {$db_prefix}users_entity WHERE username = '". $username ."'";
        $result = get_data($query);

        // check if username exists and increment it
        if ( $result[0]->num > 0 ){
            $unamePostfix = 0;
            $usrnameQuery = $username;
            
            do {
                $unamePostfix++;
                $tmpUsrnameQuery = $usrnameQuery . $unamePostfix;
                
                $query1 = "SELECT count(*) as num FROM {$db_prefix}users_entity WHERE username = '". $tmpUsrnameQuery ."'";
                $tmpResult = get_data($query1);
                
                $uname = $tmpUsrnameQuery;
            } while ( $tmpResult[0]->num > 0);
        } else {
            $uname = $username;
        }
        $username = $uname;
        /*** End Username Generation ***/
        
        $guid = register_user(
            $username,
            generate_random_cleartext_password(),
            $name,
            $email
        );
        
        if ($guid) {
            update_data("UPDATE {$db_prefix}users_entity SET pleio_guid = {$userid} WHERE guid = {$guid}");
        }
        
        $user = get_user($guid);
    } elseif (!$user && !$allow_registration) {
        throw new ShouldRegisterException;
    }

    if (!$user) {
        return false;
    }

    try {
        login($user);

        if ($user->name !== $name) {
            $user->name = $name;
        }

        if ($user->email !== $email) {
            $user->email = $email;
        }
        
        system_message(elgg_echo('wet:loginok', array($user->name)));

        /*
        if ($user->language !== $this->resourceOwner->getLanguage()) {
            $user->language = $this->resourceOwner->getLanguage();
        }

        if ($user->isAdmin() !== $this->resourceOwner->isAdmin()) {
            if ($this->resourceOwner->isAdmin()) {
                $user->makeAdmin();
            }
        }
        */

        $user->save();

        $session = elgg_get_session();
        $returnto = $session->get('last_forward_from');

        if ($returnto && pleio_is_valid_returnto($returnto)) {
            forward($returnto);
        } else {
            forward("/");
        }

        return true;
    } catch (\LoginException $e) {
        throw new CouldNotLoginException;
    }
} else if ($auth == 'oauth') {
    $provider = new ModPleio\Provider([
        "clientId" => $auth_client,
        "clientSecret" => $auth_secret,
        "url" => $auth_url,
        "redirectUri" => $returnto ? "{$site}login?returnto={$returnto}" : "{$site}login"
    ]);

    if (!isset($code)) {
        $authorizationUrl = $provider->getAuthorizationUrl();
        $_SESSION["oauth2state"] = $provider->getState();

        $header = "Location: " . $authorizationUrl;
        
        if ($idp && $login_credentials !== "true") {
            $header .= "&idp={$idp}";
        }

        header($header);
        exit;
    } elseif (empty($state) || $state !== $_SESSION["oauth2state"]) {
        // mitigate CSRF attack
        unset($_SESSION["oauth2state"]);
        forward("/");
    } else {
        try {
            $accessToken = $provider->getAccessToken("authorization_code", [
                "code" => $code
            ]);

            unset($_SESSION["oauth2state"]);

            // we could save these attributes for later use, not saving now...
            /*
            $accessToken->getToken();
            $accessToken->getRefreshToken();
            $accessToken->getExpires();
            */

            $resourceOwner = $provider->getResourceOwner($accessToken);
            $loginHandler = new ModPleio\LoginHandler($resourceOwner);

            try {
                $loginHandler->handleLogin();
                system_message(elgg_echo("loginok"));

                if ($returnto && pleio_is_valid_returnto($returnto)) {
                    forward($returnto);
                } else {
                    forward("/");
                }
            } catch (ModPleio\Exceptions\CouldNotLoginException $e) {
                register_error(elgg_echo("pleio:is_banned"));
                forward("/");
            } catch (ModPleio\Exceptions\ShouldRegisterException $e) {
                $_SESSION["pleio_resource_owner"] = $resourceOwner->toArray();
                $body = elgg_view_layout("walled_garden", [
                    "content" => elgg_view("pleio/request_access", [
                        "resourceOwner" => $resourceOwner->toArray()
                    ]),
                    "class" => "elgg-walledgarden-double",
                    "id" => "elgg-walledgarden-login"
                ]);
                echo elgg_view_page(elgg_echo("pleio:request_access"), $body, "walled_garden");
                return true;
            } catch (\RegistrationException $e) {
                register_error($e->getMessage());
                forward("/");
            }
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            register_error($e->getMessage());
            forward("/");
        }
    }
}