<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Tests\Unit\ModelTestCase;

class OrderTest extends ModelTestCase
{
    protected $order;

    public function initModel()
    {
        return new Order();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'user_id',
            'total_price',
            'address',
            'phone',
            'status',
            'note',
        ];

        $this->runConfigurationAssertions(
            $this->model,
            [
                'fillable' => $fillable,
            ]
        );
    }

    public function testUserRelation()
    {
        $relation = $this->model->user();
        $related = new User();
        $key = 'user_id';

        $this->assertBelongsToRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }

    public function testProductRelation()
    {
        $relation = $this->model->products();
        $related = new Product();
        $key = 'order_product.order_id';
        $relater = 'order_product.product_id';
        
        $this->assertBelongsToManyRelation(
            $relation,
            $this->model,
            $related,
            $key,
            $relater
        );
    }
}
