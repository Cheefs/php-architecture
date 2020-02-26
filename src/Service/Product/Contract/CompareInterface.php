<?php

declare( strict_types = 1);

namespace Service\Product\Contract;

use Model\Entity\Product;

interface CompareInterface {

    /**
     * @param Product $current
     * @param Product $next
     * @return int
     */
    public function compare( Product $current, Product $next ): int;
}
