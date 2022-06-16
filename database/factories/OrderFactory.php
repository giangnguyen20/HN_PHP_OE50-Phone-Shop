<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 1;
        $price = rand(1000, 10000);
        $user_id = rand(1,20);

        return [
            'id' => $id++,
            'user_id' => $user_id,
            'total_price' => $price,
            'address' => 'Ha Noi',
            'phone' => '0354678912',
            'status' => '1',
            'note' => 'oke'
        ];
    }
}
