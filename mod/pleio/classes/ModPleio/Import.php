<?php
namespace ModPleio;

class Import {
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
        $name = trim($name);

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