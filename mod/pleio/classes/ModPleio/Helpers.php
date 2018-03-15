<?php
namespace ModPleio;

class Helpers {
    public static function generateUsername($username) {
        $hidden = access_show_hidden_entities(true);

        while (strlen($username) < 4) {
            $username .= "0";
        }

        if (get_user_by_username($username)) {
            $i = 1;

            while (get_user_by_username($username . $i)) {
                $i++;
            }

            $result = $username . $i;
        } else {
            $result = $username;
        }

        access_show_hidden_entities($hidden);
        return $result;
    }

    public static function removeUser(\ElggUser $user) {
        if (!$user || !$user instanceof \ElggUser) {
            return false;
        }

        // make sure the user cannot login any more, also not with the "rememberme" cookie
        $user->ban("banned");
        $user->removeAdmin();
        $user->save();

        $result = Helpers::removeAllRelationships($user);
        $result &= Helpers::removeAllMetadata($user);
        $result &= Helpers::removeAllPrivateSettings($user);
        $result &= Helpers::anonymizeAccount($user);

        return $result;
    }

    public function removeAllRelationships(\ElggUser $user) {
        $dbprefix = elgg_get_config("dbprefix");
        $result = delete_data("DELETE FROM {$dbprefix}entity_relationships WHERE guid_one = {$user->guid} OR guid_two = {$user->guid}");

        return ($result !== false);
    }

    public function removeAllMetadata(\ElggUser $user) {
        $dbprefix = elgg_get_config("dbprefix");
        $result = delete_data("DELETE FROM {$dbprefix}metadata WHERE entity_guid = {$user->guid}");

        return ($result !== false);
    }

    public function removeAllPrivateSettings(\ElggUser $user) {
        $dbprefix = elgg_get_config("dbprefix");
        $result = delete_data("DELETE FROM {$dbprefix}private_settings WHERE entity_guid = {$user->guid}");

        return ($result !== false);
    }

    public static function anonymizeAccount(\ElggUser $user) {
        $dbprefix = elgg_get_config("dbprefix");

        // set site_guid to 0 as we do not want to display the entity in the listing any more
        $result = update_data("UPDATE {$dbprefix}entities SET
            site_guid = 0
            WHERE guid = {$user->guid}"
        );

        $result &= update_data("UPDATE {$dbprefix}users_entity SET 
            password = NULL,
            salt = NULL,
            password_hash = NULL,
            name = 'Verwijderde gebruiker',
            username = 'verwijderd{$user->guid}',
            email = NULL,
            pleio_guid = NULL,
            language = NULL,
            last_action = 0,
            prev_last_action = 0,
            last_login = 0,
            prev_last_login = 0
            WHERE guid = {$user->guid}"
        );

        _elgg_invalidate_cache_for_entity($user->guid);

        if (is_memcache_available()) {
            $newentity_cache = new \ElggMemcache("new_entity_cache");
            $newentity_cache->delete($user->guid);
        }

        elgg_trigger_event("update", "user", get_entity($user->guid));

        return ($result !== false);
    }
}