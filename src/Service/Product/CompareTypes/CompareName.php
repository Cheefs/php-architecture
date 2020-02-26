<?php

declare( strict_types = 1);

namespace Service\Product\CompareTypes;

use Model\Entity\Product;
use Service\Product\Contract\CompareInterface;

class CompareName implements CompareInterface {

    /**
     * @param Product $current
     * @param Product $next
     * @return int
    */
    public function compare( Product $current, Product $next ): int
    {
        return $current->getName() <=> $next->getName();
    }
}