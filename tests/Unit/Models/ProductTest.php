<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Order;
use Tests\Unit\ModelTestCase;

class ProductTest extends ModelTestCase
{
    protected $product;

    public function initModel()
    {
        return new Product();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'name',
            'slug',
            'description',
            'price',
            'accessories',
            'color',
            'warranty',
            'quantity',
            'status',
            'category_id',
        ];

        $this->runConfigurationAssertions(
            $this->model,
            [
                'table' => 'products',
                'fillable' => $fillable,
            ]
        );
    }

    public function testCategoryRelation()
    {
        $relation = $this->model->category();
        $related = new Category();
        $key = 'category_id';

        $this->assertBelongsToRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }

    public function testImageRelation()
    {
        $relation = $this->model->images();
        $related = new Image();
        $key = 'product_id';

        $this->assertHasManyRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }

    public function testCommentRelation()
    {
        $relation = $this->model->comments();
        $related = new Comment();
        $key = 'product_id';

        $this->assertHasManyRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }

    public function testOrderRelation()
    {
        $relation = $this->model->orders();
        $related = new Order();
        $key = 'order_product.product_id';
        $relater = 'order_product.order_id';

        $this->assertBelongsToManyRelation(
            $relation,
            $this->model,
            $related,
            $key,
            $relater
        );
    }
}
