<?php

namespace Tests\Unit\Models;

use App\Models\Image;
use App\Models\Product;
use Tests\Unit\ModelTestCase;

class ImageTest extends ModelTestCase
{
    protected $image;

    public function initModel()
    {
        return new Image();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'product_id',
            'name',
        ];

        $this->runConfigurationAssertions(
            $this->model,
            [
                'table' => 'images',
                'fillable' => $fillable,
            ]
        );
    }

    public function testProductRelation()
    {
        $relation = $this->model->product();
        $related = new Product();
        $key = 'product_id';

        $this->assertBelongsToRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }
}
