<?php
namespace ModPleio;
use ModPleio\Exceptions\ShouldRegisterException as ShouldRegisterException;
use ModPleio\Exceptions\CouldNotLoginException as CouldNotLoginException;

class LoginHandler {
    protected $resourceOwner;

    public function __construct(ResourceOwner $resourceOwner) {
        $this->resourceOwner = $resourceOwner;
    }

    public function handleLogin() {
        $user = get_user_by_pleio_guid_or_email($this->resourceOwner->getGuid(), $this->resourceOwner->getEmail());
        $allow_registration = elgg_get_config("allow_registration");

        if (!$user && $allow_registration) {
            $user = $this->createUser();
        } elseif (!$user && !$allow_registration) {
            if ($this->resourceOwner->isAdmin()) {
                $user = $this->createUser();
            } else {
                throw new ShouldRegisterException;
            }
        }

        if (!$user) {
            return false;
        }

        try {
            login($user);

            if ($user->name !== $this->resourceOwner->getName()) {
                $user->name = $this->resourceOwner->getName();
            }

            if ($user->email !== $this->resourceOwner->getEmail()) {
                $user->email = $this->resourceOwner->getEmail();
            }

            if ($user->language !== $this->resourceOwner->getLanguage()) {
                $user->language = $this->resourceOwner->getLanguage();
            }

            if ($user->isAdmin() !== $this->resourceOwner->isAdmin()) {
                if ($this->resourceOwner->isAdmin()) {
                    $user->makeAdmin();
                }
            }

            $user->save();

            return true;
        } catch (\LoginException $e) {
            throw new CouldNotLoginException;
        }
    }

    public function requestAccess() {
        $data = $this->resourceOwner->toArray();

        $data["profile"] = [];
        $fields = pleio_get_required_profile_fields();
        foreach ($fields as $field) {
            $data["profile"][$field->metadata_name] = get_input("custom_profile_fields_{$field->metadata_name}");
        }

        $link = get_db_link("write");
        $data = mysqli_real_escape_string($link, serialize($data));
        $time = time();

        insert_data("INSERT INTO pleio_request_access (guid, user, time_created) VALUES ({$this->resourceOwner->getGuid()}, '{$data}', {$time}) ON DUPLICATE KEY UPDATE time_created = {$time}");

        if (elgg_get_plugin_setting("notifications_for_access_request", "pleio") !== "no") {
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