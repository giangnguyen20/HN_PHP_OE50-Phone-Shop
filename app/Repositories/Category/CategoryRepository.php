<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getAllCategory()
    {
        return $this->model
            ->orderBy('id', 'DESC')
            ->paginate(config('product.PAGINATION_NUMBER'));
    }


    public function getCategoryById($id)
    {
        return $this->model->findOrFail($id);
    }
}
