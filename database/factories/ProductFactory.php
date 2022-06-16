<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category_id = rand(1,20);
        $name = Str::random(20);
        $price = rand(1000, 10000);
        $warranty = rand(1,12);
        $quantity = rand(5, 15);
        static $id = 1;

        return [
            'id' => $id++,
            'name' => $name,
            'slug' => slugHelper($name),
            'price' => $price,
            'accessories' => 'Sạc, tai nghe',
            'warranty' => $warranty,
            'quantity' => $quantity,
            'color' => 'Trắng',
            'status' => 1,
            'category_id' => $category_id,
            'created_at' => Carbon::now()->toDateString(),
            'updated_at' => Carbon::now()->toDateString(),
        ];
    }
}
