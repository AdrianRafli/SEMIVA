<?php

namespace Adrian\Website\Semiva\Controller;

class ProductController
{

    function categories(string $productId, string $categoryId): void
    {
        echo "PRODUCT $productId, CATEGORY $categoryId";
    }

}