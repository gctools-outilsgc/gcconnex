<?php
namespace ModPleio;

class AccessRequest {
    public function __construct($data) {
        $this->id = (int) $data->id;
        $this->user = unserialize($data->user);
        $this->time_created = $data->time_created;
    }

    public function getURL() {
        return $this->user["url"];
    }

    public function getIconURL() {
        return $this->user["icon"];
    }

    public function getType() {
        return "accessRequest";
    }

    public function approve() {
        $resourceOwner = new ResourceOwner($this->user);
        $loginHandler = new LoginHandler($resourceOwner);
        $site = elgg_get_site_entity();

        try {
            $user = $loginHandler->createUser();
            if ($user) {
                $this->remove();
                $this->sendEmail(
                    elgg_echo("pleio:approved:subject", [$site->name]),
                    elgg_echo("pleio:approved:body", [
                        $user->name,
                        $site->name,
                        $site->url
                    ])
                );
                return true;
            }
        } catch (\RegistrationException $e) {
            register_error($e->getMessage());
        }

        return false;
    }

    public function decline() {
        $site = elgg_get_site_entity();
        $resourceOwner = new ResourceOwner($this->user);

        if ($this->remove()) {
            $this->sendEmail(
                elgg_echo("pleio:declined:subject", [$site->name]),
                elgg_echo("pleio:declined:body", [
                    $resourceOwner->getName(),
                    $site->name
                ])
            );

            return true;
        }

        return false;
    }

    public function remove() {
        return delete_data("DELETE FROM pleio_request_access WHERE id = {$this->id}");
    }

    private function sendEmail($subject, $body, $params = null) {
        $site = elgg_get_site_entity();

        if ($site->email) {
            $from = $site->email;
        } else {
            $from = "noreply@" . get_site_domain($site->guid);
        }

        return elgg_send_email($from, $this->user["email"], $subject, $body, $params);
    }
}