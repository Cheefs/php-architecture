<?php

declare(strict_types = 1);

namespace Service\SocialNetwork;


interface SocialNetworkInterface
{
    /**
     * @return bool
     */
    public function login(): bool;
}
