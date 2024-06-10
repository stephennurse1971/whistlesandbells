<?php

namespace App\Services;

use App\Repository\ProductRepository;

class Product
{
    public function getProduct()
    {
        return $this->productRepository->findAll();
    }

    public function getProductFooter()
    {
        return $this->productRepository->findBy([
            'isActive'=>'1'
        ]);
    }
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
}