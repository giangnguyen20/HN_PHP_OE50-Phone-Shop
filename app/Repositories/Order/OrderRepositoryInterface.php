<?php
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getTheOrderQuantity();
    
    public function getAllWithUsers();
    
    public function getOrderById($id);
    
    public function getOrderWithUser($id);

    public function getOrderbyUserId($id);

    public function getStatistic();
}
