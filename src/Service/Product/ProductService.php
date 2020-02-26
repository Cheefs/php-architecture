<?php

declare(strict_types = 1);

namespace Service\Product;

use Model;
use Model\Entity\Product;
use Model\Repository\ProductRepository;
use Service\Product\CompareTypes\CompareName;
use Service\Product\CompareTypes\ComparePrice;

class ProductService
{
    /**
     * Получаем информацию по конкретному продукту
     * @param int $id
     * @return Product|null
     */
    public function getInfo(int $id): ?Product
    {
        $product = $this->getProductRepository()->search([$id]);
        return count($product) ? $product[0] : null;
    }

    /**
     * Получаем все продукты
     * @param string $sortType
     * @return Product[]
     */
    public function getAll(string $sortType): array
    {
        $productList = $this->getProductRepository()->fetchAll();

        switch ( $sortType ) {
            case 'price': {
                $compare = new ComparePrice();
                break;
            }
            case 'name': {
                $compare = new CompareName();
                break;
            }
            default: {
                $compare = null;
                break;
            }
        }

        if ( !$compare ) {
            return $productList;
        }

        return (new ProductSort( $compare ) )->sort( $productList );
    }

    /**
     * Фабричный метод для репозитория Product
     * @return ProductRepository
     */
    protected function getProductRepository(): ProductRepository
    {
        return new ProductRepository();
    }
}
