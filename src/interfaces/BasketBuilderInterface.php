<?php

declare(strict_types=1);

namespace interfaces;

use Service\Billing\BillingInterface;
use Service\Communication\CommunicationInterface;
use Service\Discount\DiscountInterface;
use Service\User\SecurityInterface;

interface BasketBuilderInterface
{
    /**
     * @return BillingInterface
    */
    public function getBilling(): ?BillingInterface;
    /**
     * @return DiscountInterface
     */
    public function getDiscount(): ?DiscountInterface;
    /**
     * @return CommunicationInterface
     */
    public function getCommunication(): ?CommunicationInterface;
    /**
     * @return SecurityInterface
     */
    public function getSecurity(): ?SecurityInterface;
    /**
     * @param BillingInterface $billing
     * @return BasketBuilderInterface
     */
    public function setBilling( BillingInterface $billing ): self;
    /**
     * @param DiscountInterface $discount
     * @return BasketBuilderInterface
     */
    public function setDiscount( DiscountInterface $discount ): self;
    /**
     * @param CommunicationInterface $communication
     * @return BasketBuilderInterface
     */
    public function setCommunication( CommunicationInterface $communication ): self;
    /**
     * @param SecurityInterface $security
     * @return BasketBuilderInterface
     */
    public function setSecurity( SecurityInterface $security ): self;
}