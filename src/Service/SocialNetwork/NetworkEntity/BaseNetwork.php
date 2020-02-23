<?php

declare(strict_types = 1);

namespace Service\SocialNetwork\NetworkEntity;

abstract class BaseNetwork
{
    private string $username;
    private string $password;
    private string $authKey;
    private string $networkUrl;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setPassword(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     */
    public function setAuthKey(string $authKey): void
    {
        $this->authKey = $authKey;
    }

    public function __construct( string $password, string $username )
    {
        $this->password = $password;
        $this->username = $username;
    }

    public function validateFields() {
        return trim( $this->username ) && trim( $this->password );
    }

    public abstract function authorize(): bool;
}
