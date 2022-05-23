<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Product;
use Tests\Unit\ModelTestCase;

class CategoryTest extends ModelTestCase
{
    protected $category;

    public function initModel()
    {
        return new Category();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'name',
            'slug',
        ];

        $this->runConfigurationAssertions(
            $this->model,
            [
                'table' => 'categories',
                'fillable' => $fillable,
            ]
        );
    }

    public function testProductRelation()
    {
        $relation = $this->model->products();
        $related = new Product();
        $key = 'category_id';

        $this->assertHasManyRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }
}
