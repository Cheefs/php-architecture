<?php

declare(strict_types = 1);

namespace Service\SocialNetwork\NetworkEntity;


class SomeNetwork extends BaseNetwork
{
    public function authorize(): bool
    {
        $authKey = 'auth_key';
        $this->setAutahKey( $authKey );
        return $authKey ? true : false;
    }
}
