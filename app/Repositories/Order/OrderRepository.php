<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use Carbon\Carbon;

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
    
    public function getAllWithUsers()
    {
        return $this->model->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(config('auth.orderPagination'));
    }

    public function getOrderById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getOrderWithUser($id)
    {
        return $this->model->with(['user'])
            ->findOrFail($id);
    }

    public function getOrderByUserId($id)
    {
        return $this->model->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function getStatistic()
    {
        $year = Carbon::now()->year;
        $initChart = config('auth.data');
        $orderList = $this->model->where('status', config('auth.orderStatus.complete'))
            ->whereYear('updated_at', $year)
            ->get();

        foreach ($initChart as $month => $value) {
            foreach ($orderList as $item) {
                if ($item->created_at->format('M') == $month) {
                    $initChart[$month] += $item->total_price;
                }
            }
        }

        return json_encode(array_merge($initChart));
    }
}
