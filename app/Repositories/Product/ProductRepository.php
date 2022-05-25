<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Product::class;
    }

    public function getProductWithImages()
    {
        return $this->model->with('images')
            ->select('products.*')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(config('product.PAGINATION_NUMBER'));
    }

    public function getProductByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function getProductById($id)
    {
        return $this->model->findOrFail($id);
    }
}
