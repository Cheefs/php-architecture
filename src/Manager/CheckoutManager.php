<?php

declare(strict_types = 1);

namespace Manager;

use Service\Billing\BillingInterface;
use Service\Billing\Exception\BillingException;
use Service\Communication\CommunicationInterface;
use Service\Communication\Exception\CommunicationException;
use Service\Discount\DiscountInterface;
use Service\User\SecurityInterface;

/**
 * 1. Примените паттерн Фасад (Facade) к методам checkout() и checkoutProcess() класса Service\Order\Basket.
 *
 * Класс Фасад, для метода checkoutProcess
 * включил использование синтаксиса php 7.4 , чтоб описыать типы данных в переменных
 */
class CheckoutManager
{
    private BillingInterface $billing;
    private DiscountInterface $discount;
    private SecurityInterface $security;
    private CommunicationInterface $communication;

    public function __construct(
        BillingInterface $billing,
        DiscountInterface $discount,
        SecurityInterface $security,
        CommunicationInterface $communication
    ) {
        $this->billing = $billing;
        $this->discount = $discount;
        $this->security = $security;
        $this->communication = $communication;
    }

    public function checkoutProcess( int $totalPrice ): void {
        $discount = $this->discount->getDiscount();
        $totalPrice = $totalPrice - $totalPrice / 100 * $discount;
        try {
            $this->billing->pay($totalPrice);
            $user = $this->security->getUser();
            $this->communication->process($user, 'checkout_template');
        } catch ( BillingException $exception ) {
            // $this->billing->doSomething( $exception );
        } catch ( CommunicationException $exception ) {
            // $this->communication->doSomething( $exception );
        }
    }
}
