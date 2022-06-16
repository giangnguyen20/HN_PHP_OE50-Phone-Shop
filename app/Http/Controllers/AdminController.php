<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class AdminController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $orderRepo;
    protected $userRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        CategoryRepositoryInterface $categoryRepo,
        OrderRepositoryInterface $orderRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->orderRepo = $orderRepo;
        $this->userRepo = $userRepo;
    }
    
    public function index()
    {
        $data = [];
        $data['product'] = $this->productRepo->getAll()->count();
        $data['order'] = $this->orderRepo->getAll()->count();
        $data['user'] = $this->userRepo->getAll()->count();
        $data['category'] = $this->categoryRepo->getAll()->count();

        $year = Carbon::now()->year;
        $chartData = $this->orderRepo->getStatistic();

        return view('admin.index')->with([
            'data' => $data,
            'year' => $year,
            'chartData' => $chartData,
        ]);
    }
}
