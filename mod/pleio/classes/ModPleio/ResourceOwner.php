<?php
namespace ModPleio;

use League\OAuth2\Client\Tool\ArrayAccessorTrait;
use League\OAuth2\Client\Provider\GenericResourceOwner;

class ResourceOwner extends GenericResourceOwner {
    use ArrayAccessorTrait;

    protected $response;

    public function __construct(array $response = array()) {
        $this->response = $response;
    }

    public function getGuid() {
        return $this->getValueByKey($this->response, "guid");
    }

    public function getUsername() {
        return $this->getValueByKey($this->response, "username");
    }

    public function getEmail() {
        return $this->getValueByKey($this->response, "email");
    }

    public function getIcon() {
        return $this->getValueByKey($this->response, "icon");
    }

    public function getLanguage() {
        return $this->getValueByKey($this->response, "language");
    }

    public function getName() {
        return $this->getValueByKey($this->response, "name");
    }

    public function getUrl() {
        return $this->getValueByKey($this->response, "url");
    }

    public function getProfile() {
        if (is_array($this->getValueByKey($this->response, "profile"))) {
            return $this->getValueByKey($this->response, "profile");
        }

        return [];
    }

    public function isAdmin() {
        return $this->getValueByKey($this->response, "isAdmin");
    }

    public function toArray() {
        return $this->response;
    }
}