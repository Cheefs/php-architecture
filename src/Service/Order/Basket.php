<?php

declare(strict_types = 1);

namespace Service\Order;

use Manager\CheckoutManager;
use Model;
use Model\Entity\Product;
use Model\Repository\ProductRepository;
use Service\Billing\Exception\BillingException;
use Service\Billing\BillingInterface;
use Service\Billing\Transfer\Card;
use Service\Communication\Exception\CommunicationException;
use Service\Communication\CommunicationInterface;
use Service\Communication\Sender\Email;
use Service\Discount\DiscountInterface;
use Service\Discount\NullObject;
use Service\User\SecurityInterface;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Basket
{
    /**
     * Сессионный ключ списка всех продуктов корзины
     */
    private const BASKET_DATA_KEY = 'basket';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Добавляем товар в заказ
     * @param int $productId
     * @return void
     */
    public function addProduct(int $productId): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if (!in_array($productId, $basket, true)) {
            $basket[] = $productId;
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Проверяем, лежит ли продукт в корзине или нет
     * @param int $productId
     * @return bool
     */
    public function isProductInBasket(int $productId): bool
    {
        return in_array($productId, $this->getProductIds(), true);
    }

    /**
     * Получаем информацию по всем продуктам в корзине
     * @return Product[]
     */
    public function getProductsInfo(): array
    {
        $productIds = $this->getProductIds();
        return $this->getProductRepository()->search($productIds);
    }

    /**
     * @return float
     */
    public function calculateProductsTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->getProductsInfo() as $product) {
            $totalPrice += $product->getPrice();
        }
        return $totalPrice;
    }

    /**
     * Оформление заказа
     *  Изменение функции, на работу с фассадом, вторая функция логически должна была уйти в фасад, который выполняет работу
     * всех переданных в него классов, поэтому с этого класса я удалил функцию checkoutProcess
     * @return void
     */
    public function checkout(): void
    {
        $manager = new CheckoutManager(
            new Card(),
            new NullObject(),
            new Security($this->session),
            new Email(),
        );
        $manager->checkoutProcess( $this->getTotalPrice() );
    }

    /**
     * Получение полнолной цены корзины
     * @return int
     **/
    private function getTotalPrice(): int {
        return array_reduce( $this->getProductsInfo(), function ( int $carry, Product $product ) {
            return $carry + $product->getPrice();
        }, 0);
    }

    /**
     * Фабричный метод для репозитория Product
     * @return ProductRepository
     */
    protected function getProductRepository(): ProductRepository
    {
        return new ProductRepository();
    }

    /**
     * Получаем список id товаров корзины
     * @return array
     */
    private function getProductIds(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }
}
