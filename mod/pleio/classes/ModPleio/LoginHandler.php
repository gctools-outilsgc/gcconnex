<?php
namespace ModPleio;
use ModPleio\Exceptions\ShouldRegisterException as ShouldRegisterException;
use ModPleio\Exceptions\ShouldValidateException as ShouldValidateException;
use ModPleio\Exceptions\CouldNotLoginException as CouldNotLoginException;

class LoginHandler {
    protected $resourceOwner;

    public function __construct(ResourceOwner $resourceOwner) {
        $this->resourceOwner = $resourceOwner;
    }

    public function handleLogin() {
        $user = get_user_by_pleio_guid_or_email($this->resourceOwner->getGuid(), $this->resourceOwner->getEmail());
        $allow_registration = elgg_get_config("allow_registration");

        if (!$user) {
            if ($allow_registration) {
                $user = $this->createUser();
            } else {
                if ($this->resourceOwner->isAdmin()) {
                    $user = $this->createUser();
                } else {
                    throw new ShouldRegisterException;
                }
            }
        }

        if (!$user) {
            return false;
        }

        if ($user->name !== $this->resourceOwner->getName()) {
            $user->name = $this->resourceOwner->getName();
        }

        if ($user->email !== $this->resourceOwner->getEmail()) {
            $user->email = $this->resourceOwner->getEmail();
        }

        if ($user->language !== $this->resourceOwner->getLanguage()) {
            $user->language = $this->resourceOwner->getLanguage();
        }

        if ($this->resourceOwner->isAdmin()) {
            $ia = elgg_set_ignore_access(true);

            if (!$user->isAdmin()) {
                $user->makeAdmin();
                $user->save();
            }

            if ($user->isBanned()) {
                unban_user($user->guid);
                $user->banned = "no";
                $user->save();
            }

            elgg_set_ignore_access($ia);
        }

        $user->save();

        try {
            login($user, true);
            return $user;
        } catch (\LoginException $e) {
            throw new CouldNotLoginException;
        }
    }

    public function requestAccess($notify_admin = true) {
        $data = $this->resourceOwner->toArray();

        $data["profile"] = [];
        $fields = pleio_get_required_profile_fields();
        foreach ($fields as $field) {
            $data["profile"][$field->metadata_name] = get_input("custom_profile_fields_{$field->metadata_name}");
        }

        $link = get_db_link("write");
        $data = mysqli_real_escape_string($link, serialize($data));
        $time = time();

        $result = insert_data("INSERT INTO pleio_request_access (guid, user, time_created) VALUES ({$this->resourceOwner->getGuid()}, '{$data}', {$time}) ON DUPLICATE KEY UPDATE time_created = {$time}");

        if (elgg_get_plugin_setting("notifications_for_access_request", "pleio") !== "no" && $notify_admin) {
            $site = elgg_get_site_entity();
            $admins = elgg_get_admins();
            foreach ($admins as $admin) {
                notify_user(
                    $admin->guid,
                    $site->guid,
                    elgg_echo("pleio:admin:access_request:subject", [$site->name]),
                    elgg_echo("pleio:admin:access_request:body", [
                        $admin->name,
                        $this->resourceOwner->getName(),
                        $site->name,
                        "{$site->url}admin/users/access_requests"
                    ])
                );
            }
        }

        if ($result) {
            $this->requestId = $result;
        }

        return $result;
    }

    public function sendValidationEmail() {
        if (!$this->requestId) {
            return;
        }

        $site = elgg_get_site_entity();

        return elgg_send_email(
            Helpers::getSiteEmail(),
            $this->resourceOwner->getEmail(),
            elgg_echo("pleio:validation_email:subject", [$site->name]),
            elgg_echo("pleio:validation_email:body", [
                $this->resourceOwner->getName(),
                $site->name,
                $this->getValidationURL()
            ])
        );
    }

    public function getValidationURL() {
        $data = [
            "request_id" => $this->requestId,
            "guid" => $this->resourceOwner->getGuid()
        ];

        $site_url = elgg_get_site_url();
        $code = Helpers::signData($data);
        return "{$site_url}validate_access?code={$code}";
    }

    public function createUser() {
        $pleio_guid = (int) $this->resourceOwner->getGuid();

        $guid = register_user(
            Helpers::generateUsername($this->resourceOwner->getUsername()),
            generate_random_cleartext_password(),
            $this->resourceOwner->getName(),
            $this->resourceOwner->getEmail()
        );

        $db_prefix = elgg_get_config('dbprefix');

        if ($guid) {
            update_data("UPDATE {$db_prefix}users_entity SET pleio_guid = {$pleio_guid} WHERE guid={$guid}");

            $profile = $this->resourceOwner->getProfile();
            if (is_array($profile)) {
                foreach ($this->resourceOwner->getProfile() as $name => $value) {
                    create_metadata($guid, $name, $value, "", $guid);
                }
            }

            return get_user($guid);
        }

        return false;
    }
}