<?php

declare(strict_types = 1);

namespace Service\Product;

use Model;
use Service\Product\Contract\CompareInterface;

class ProductSort
{
    private $compare;

    public function __construct( CompareInterface $compare )
    {
        $this->compare = $compare;
    }

    public function sort( array $products ): array
    {
        usort( $products, [ $this->compare, 'compare' ]);
        return $products;
    }
}
