<?php

namespace Service\Order;

use interfaces\BasketBuilderInterface;
use Model\Entity\Checkout;

class CheckoutProcess {

    /**
     * @var Checkout
     */
    private $checkout;

    public function __construct( BasketBuilderInterface $builder )
    {
        $this->checkout = $builder->build();
    }

    /**
     * @param int $cartTotalPrice
     * @return void
    */
    public function doProcess( int $cartTotalPrice ): void {

        $discount = $this->checkout->getDiscount();
        $user = $this->checkout->getSecurity()->getUser();

        $totalPrice = $cartTotalPrice -  $cartTotalPrice / 100 * $discount ;

        try {
            $this->checkout->getBilling()->pay($totalPrice);
            $this->checkout->getCommunication()->process($user, 'checkout_template');
        } catch ( \Exception $e) {
            /// transaction rollback ....
        }
    }
}