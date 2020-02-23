<?php

declare(strict_types = 1);

namespace Service\SocialNetwork;


use Service\SocialNetwork\NetworkEntity\BaseNetwork;

class SomeNetworkAdapter implements SocialNetworkInterface
{
    private BaseNetwork $socialNetwork;

    public function __construct(BaseNetwork $socialNetwork ) {
        $this->socialNetwork = $socialNetwork;
    }
    /**
     * @inheritDoc
     */
    public function login(): bool
    {
        if ( $this->socialNetwork->validateFields() )  {
            /// и если нужно, можно выполнить какието другие действия
            return $this->socialNetwork->authorize();
        }
        return false;
    }
}
