<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getProductWithImages();

    public function getProductByName($name);

    public function getProductById($id);
}
