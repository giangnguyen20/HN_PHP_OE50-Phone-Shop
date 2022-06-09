<?php

namespace App\Repositories\Order;

use Carbon\Carbon;
use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function getTheOrderQuantity()
    {
        $time = Carbon::now()->subWeek(1);

        $total = $this->model->where('updated_at', '>', $time)
            ->where('status', config('auth.orderStatus.complete'))
            ->count();
            
        return $total;
    }
}
