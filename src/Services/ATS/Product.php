<?php

namespace App\Services\ATS;

use App\Repository\ATS\ProductRepository;

class Product
{
    public function getProductAll()
    {
        return $this->productRepository->findAll();
    }

    public function getProductActive()
    {
        return $this->productRepository->findBy([
            'isActive'=>'1'
        ]);
    }
    public function getProductFooter()
    {
        return $this->productRepository->findBy([
            'includeInFooter'=>'1'
        ]);
    }
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
}