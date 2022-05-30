<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 1;
        $name = Str::random(15);

        return [
            'id' => $id++,
            'name' => $name,
            'slug' => slugHelper($name),
        ];
    }
}
