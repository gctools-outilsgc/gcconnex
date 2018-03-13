<?php
namespace ModPleio;

class Import {
    public static function run($csv_location, $columns, \ElggUser $initiator) {
        global $CONFIG;

        $site = elgg_get_site_entity();
        $profile_fields = get_config("profile_fields");

        $fh = fopen($csv_location, "r");
        if (!$fh) {
            throw new Exception("Invalid import file");
        }

        $stats = [
            "created" => 0,
            "updated" => 0,
            "error" => 0
        ];

        $skip_first_line = true;
        while (($data = fgetcsv($fh, 0, ";")) !== false) {
            if ($skip_first_line) {
                $skip_first_line = false;
                continue;
            }

            $data = Import::extractData($columns, $data);

            $user = Import::getUserByAttributes($data);
            if (!$user) {
                $user = Import::registerUser($data);
                if ($user) {
                    $stats["created"] += 1;
                } else {
                    $stats["error"] += 1;
                }
            } else {
                $stats["updated"] += 1;
            }

            if (!$user) {
                continue;
            }

            if ($data["email"] && $user->email !== $data["email"]) {
                $user->email = $data["email"];
            }

            if ($data["name"] && $user->name !== $data["name"]) {
                $user->name = $data["name"];
            }

            foreach ($columns as $id => $metadata_name) {
                $value = $data[$metadata_name];
                if (empty($value)) {
                    continue;
                }

                if (!array_key_exists($metadata_name, $profile_fields)) {
                    continue;
                }

                $field_type = $profile_fields[$metadata_name];

                if ($profile_fields[$metadata_name] == "tags") {
                    elgg_delete_metadata([
                        "guid" => $user->guid,
                        "metadata_name" => $metadata_name,
                        "limit" => 0
                    ]);

                    foreach (string_to_tag_array($value) as $v) {
                        create_metadata($user->guid, $metadata_name, $v, "", $user->guid, get_default_access(), true, $site->guid);
                    }
                } else {
                    create_metadata($user->guid, $metadata_name, $value, "", $user->guid, get_default_access(), false, $site->guid);
                }
            }

            $user->save();
        }

        unlink($csv_location);

        return $stats;
    }

    public function extractData($columns, $data) {
        $result = [];
        foreach ($columns as $id => $metadata_name) {
            if (!$metadata_name) {
                continue;
            }

            $result[$metadata_name] = $data[$id];
        }

        return $result;
    }

    public function registerUser($data) {
        if (!$data["name"] || !$data["email"]) {
            return false;
        }

        $user = false;

        try {
            $username = Import::generateUniqueUsername($data);
            $password = generate_random_cleartext_password();
            $guid = register_user($username, $password, $data["name"], $data["email"]);
            elgg_set_user_validation_status($guid, true, "email");
            $user = get_entity($guid);
        } catch (Exception $e) {
            elgg_log("Could not register user " . $e->getMessage(), "ERROR");
        }

        return $user;
    }

    public function generateUniqueUsername($data) {
        $email = $data["email"];
        list($name, $email) = explode("@", $email);
        $name = preg_replace("/[^a-zA-Z0-9\.]+/", "", trim($name));

        while (strlen($name) < 4) {
            $name .= "0";
        }

        $hidden = access_show_hidden_entities(true);

        if (get_user_by_username($name)) {
            $i = 1;

            while (get_user_by_username($name . $i)) {
                $i++;
            }

            $result = $name . $i;
        } else {
            $result = $name;
        }

        access_show_hidden_entities($hidden);

        return $result;
    }

    public function getUserByAttributes($data) {
        $user = false;

        if ($data["guid"]) {
            $user = get_entity($data["guid"]);
        } elseif ($data["username"]) {
            $user = get_user_by_username($data["username"]);
        } elseif ($data["email"]) {
            $users = get_user_by_email($data["email"]);
            $user = $users[0];
        }

        return $user;
    }
}