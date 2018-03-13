<?php
require_once(dirname(__FILE__) . "/lib/background_tasks.php");
require_once(dirname(__FILE__) . "/../../vendor/autoload.php");
spl_autoload_register("pleio_autoloader");
function pleio_autoloader($class) {
    $filename = "classes/" . str_replace("\\", "/", $class) . ".php";
    if (file_exists(dirname(__FILE__) . "/" . $filename)) {
        include($filename);
    }
}

elgg_register_event_handler("init", "system", "pleio_init");

function pleio_init() {
    elgg_unregister_page_handler("login");
    elgg_register_page_handler("login", "pleio_page_handler");

    elgg_unregister_action("register");
    elgg_unregister_page_handler("register");
    elgg_register_page_handler("register", "pleio_register_page_handler");

    elgg_unregister_action("logout");
    elgg_register_action("logout", dirname(__FILE__) . "/actions/logout.php", "public");

    elgg_unregister_action("avatar/crop");
    elgg_unregister_action("avatar/remove");
    elgg_register_action("avatar/remove", dirname(__FILE__) . "/actions/avatar/remove.php");

    elgg_unregister_action("avatar/upload");
    elgg_register_action("avatar/upload", dirname(__FILE__) . "/actions/avatar/upload.php");

    elgg_unregister_action("user/passwordreset");
    elgg_unregister_action("user/requestnewpassword");

    elgg_unregister_action("admin/user/resetpassword");
    elgg_unregister_action("admin/user/delete");
    elgg_register_action("admin/user/delete", dirname(__FILE__) . "/actions/admin/user/delete.php", "admin");

    elgg_unregister_action("admin/user/unban");
    elgg_register_action("admin/user/unban", dirname(__FILE__) . "/actions/admin/user/unban.php", "admin");

    elgg_unregister_menu_item("page", "users:unvalidated");
    elgg_unregister_menu_item("page", "users:add");
    elgg_unregister_action("useradd");

    elgg_register_plugin_hook_handler("register", "menu:user_hover", "pleio_user_hover_menu");

    elgg_unregister_plugin_hook_handler("usersettings:save", "user", "users_settings_save");

    elgg_unregister_action("admin/site/update_advanced");
    elgg_register_action("admin/site/update_advanced", dirname(__FILE__) . "/actions/admin/site/update_advanced.php", "admin");

    elgg_register_page_handler("access_requested", "pleio_access_requested_page_handler");
    elgg_register_page_handler("validate_access", "pleio_access_validate_access_page_handler");

    elgg_register_action("pleio/request_access", dirname(__FILE__) . "/actions/request_access.php", "public");
    elgg_register_action("admin/pleio/process_access", dirname(__FILE__) . "/actions/admin/process_access.php", "admin");

    elgg_register_plugin_hook_handler("public_pages", "walled_garden", "pleio_public_pages_handler");
    elgg_register_plugin_hook_handler("action", "admin/site/update_basic", "pleio_admin_update_basic_handler");
    elgg_register_plugin_hook_handler("entity:icon:url", "user", "pleio_user_icon_url_handler");

    elgg_register_admin_menu_item("administer", "access_requests", "users");

    elgg_register_admin_menu_item("administer", "import", "users");
    elgg_register_action("admin/user/import_step1", dirname(__FILE__) . "/actions/admin/user/import_step1.php", "admin");
    elgg_register_action("admin/user/import_step2", dirname(__FILE__) . "/actions/admin/user/import_step2.php", "admin");

    elgg_extend_view("css/elgg", "pleio/css/site");
    elgg_extend_view("page/elements/head", "page/elements/topbar/fix");
    elgg_extend_view("page/elements/foot", "page/elements/stats");

    if (elgg_is_active_plugin("web_services")) {
        elgg_ws_expose_function(
            "pleio.verifyuser",
            "pleio_verify_user_creds",
            array(
                "user" => array('type' => 'string', 'required' => true),
                "password" => array('type' => 'string', 'required' => true)
            ),
            'Verifies user credentials based on email and password (for use with Pleio_account).',
            'POST',
            false,
            false
        );

        function pleio_verify_user_creds($user, $password) {
            $user_entity = get_user_by_email($user)[0];

            if (!$user_entity) {
                return json_encode(false);
            }

            $username = $user_entity->username;
            $name = $user_entity->name;
            $admin = elgg_is_admin_user($user_entity->guid);
            $valid = elgg_authenticate($username, $password);

            $return = array("name" => $name, "valid" => $valid, "admin" => $admin);

            return $return;
        }
    }
}

function pleio_page_handler($page) {
    include(dirname(__FILE__) . "/pages/login.php");
    return true;
}

function pleio_access_requested_page_handler($page) {
    $body = elgg_view_layout("walled_garden", [
        "content" => elgg_view("pleio/access_requested", [
            "resourceOwner" => $_SESSION["pleio_resource_owner"]
        ]),
        "class" => "elgg-walledgarden-double",
        "id" => "elgg-walledgarden-login"
    ]);

    echo elgg_view_page(elgg_echo("pleio:access_requested"), $body, "walled_garden");
    return true;
}

function pleio_access_validate_access_page_handler($page) {
    include(dirname(__FILE__) . "/pages/validate_access.php");
    return true;
}

function pleio_register_page_handler($page) {
    forward("/login?method=register");

    return true;
}

function pleio_admin_update_basic_handler($hook, $type, $value, $params) {
    $site = elgg_get_site_entity();

    $site_permission = get_input("site_permission");
    if ($site_permission) {
        set_config("site_permission", $site_permission, $site->guid);
    }
}

function pleio_public_pages_handler($hook, $type, $value, $params) {
    $value[] = "action/pleio/request_access";
    $value[] = "validate_access";
    $value[] = "access_requested";
    return $value;
}

function pleio_user_icon_url_handler($hook, $type, $value, $params) {
    global $CONFIG;
    
    $auth = elgg_get_plugin_setting('auth', 'pleio');
    $auth_url = elgg_get_plugin_setting('auth_url', 'pleio', $CONFIG->pleio->url);

    if ($auth == 'oidc') {
        $auth_url = str_replace("openid", "", $auth_url);
    }

    $entity = $params["entity"];
    $size = $params["size"];

    if (!$entity) {
        return $value;
    }

    if (!in_array($size, ["large", "medium", "small", "tiny", "master", "topbar"])) {
        $size = "medium";
    }

    $dbprefix = elgg_get_config("dbprefix");
    $guid = (int) $entity->guid;

    $result = get_data_row("SELECT pleio_guid FROM {$dbprefix}users_entity WHERE guid = $guid");
    if ($result) {
        $pleio_guid = $result->pleio_guid;
    } else {
        $pleio_guid = 0;
    }

    $url = $auth_url . "mod/profile/icondirect.php?guid={$pleio_guid}&size={$size}";

    if ($entity->icontime) {
        $url .= "&lastcache={$entity->icontime}";
    } elseif ($entity->last_login) {
        $url .= "&lastcache={$entity->last_login}";
    }

    return $url;
}

function pleio_user_hover_menu($hook, $type, $items, $params) {
    foreach ($items as $key => $item) {
        if (in_array($item->getName(), ["resetpassword"])) {
            unset($items[$key]);
        }
    }

    return $items;
}

function pleio_users_settings_save() {
    elgg_set_user_default_access();
}

function pleio_is_valid_returnto($url) {
    $site_url = parse_url(elgg_get_site_url());
    $returnto_url = parse_url($url);

    if (!$site_url || !$returnto_url) {
        return false;
    }

    // check returnto is relative or absolute
    if (!$returnto_url["host"] && $returnto_url["path"]) {
        return true;
    } else {
        if ($site_url["scheme"] !== $returnto_url["scheme"]) {
            return false;
        }

        if ($site_url["host"] !== $returnto_url["host"]) {
            return false;
        }
    }

    return true;
}

function get_user_by_pleio_guid_or_email($guid, $email) {
    $guid = (int) $guid;
    if (!$guid) {
        return false;
    }

    $email = sanitize_string($email);
    if (!$email) {
        return false;
    }

    $dbprefix = elgg_get_config("dbprefix");
    $result = get_data_row("SELECT guid FROM {$dbprefix}users_entity WHERE pleio_guid = {$guid}");
    if ($result) {
        return get_entity($result->guid);
    }

    $result = get_data_row("SELECT guid FROM {$dbprefix}users_entity WHERE email = '{$email}'");
    if ($result) {
        update_data("UPDATE {$dbprefix}users_entity SET pleio_guid = {$guid} WHERE guid={$result->guid}");
        return get_entity($result->guid);
    }

    return false;
}

function pleio_get_required_profile_fields() {
    if (!elgg_is_active_plugin("profile_manager")) {
        return [];
    }

    $result = profile_manager_get_categorized_fields(null, true, true, true, $profile_type_guid);

    if (empty($result["categories"])) {
        return [];
    }

    $return = [];
    foreach ($result["categories"] as $category_guid => $category) {
        foreach ($result["fields"][$category_guid] as $field) {
            if ($field->show_on_register == "yes" && $field->mandatory == "yes") {
                $return[] = $field;
            }
        }
    }

    return $return;
}

function pleio_get_domain_from_email($email) {
    return substr(strrchr($email, "@"), 1);
}

function pleio_domain_in_whitelist($domain) {
    $plugin_setting = elgg_get_plugin_setting("domain_whitelist", "pleio");
    $domains = $plugin_setting ? explode(",", $plugin_setting) : [];

    $domains = array_map(function($domain) { return trim($domain); }, $domains);

    if (in_array($domain, $domains)) {
        return true;
    }

    return false;
}

function pleio_schedule_in_background($function, $param) {
    $input = base64_encode(json_encode([
        "http_host" => $_SERVER["HTTP_HOST"],
        "https" => $_SERVER["HTTPS"],
        "env" => [
            "DB_USER" => getenv("DB_USER"),
            "DB_PASS" => getenv("DB_PASS"),
            "DB_NAME" => getenv("DB_NAME"),
            "DB_HOST" => getenv("DB_HOST"),
            "DB_PREFIX" => getenv("DB_PREFIX"),
            "DATAROOT" => getenv("DATAROOT"),
            "PLEIO_ENV" => getenv("PLEIO_ENV"),
            "SMTP_DOMAIN" => getenv("SMTP_DOMAIN"),
            "BLOCK_EMAIL" => getenv("BLOCK_EMAIL"),
            "MEMCACHE_ENABLED" => getenv("MEMCACHE_ENABLED"),
            "MEMCACHE_PREFIX" => getenv("MEMCACHE_PREFIX"),
            "MEMCACHE_SERVER_1" => getenv("MEMCACHE_SERVER_1"),
            "ELASTIC_INDEX" => getenv("ELASTIC_INDEX"),
            "ELASTIC_SERVER_1" => getenv("ELASTIC_SERVER_1")
        ],
        "function" => $function,
        "param" => $param
    ]));

    $script_location = dirname(__FILE__) . "/procedures/run_function.php";

    if (file_exists("/usr/local/bin/php")) {
        $binary = "/usr/local/bin/php";
    } else {
        $binary = "php";
    }

    if (PHP_OS === "WINNT") {
        pclose(popen("start /B {$binary} {$script_location} {$input}", "r"));
    } else {
        exec("{$binary} {$script_location} {$input} > /tmp/pleio-background.log &");
    }
}
