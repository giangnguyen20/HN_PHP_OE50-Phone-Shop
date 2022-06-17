<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use App\Http\Controllers\AdminController;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class AdminControllerTest extends TestCase
{
    protected $products;
    protected $categories;
    protected $orders;
    protected $users;
    protected $productRepo;
    protected $categoryRepo;
    protected $orderRepo;
    protected $userRepo;
    protected $controller;

    public function setUp() : void
    {
        parent::setUp();
        $this->products = Product::factory()->count(10)->make();
        $this->categories = Category::factory()->count(10)->make();
        $this->orders = Order::factory()->count(10)->make();
        $this->users = User::factory()->count(10)->make();
        $this->productRepo = Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $this->categoryRepo = Mockery::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->orderRepo = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->userRepo = Mockery::mock(UserRepositoryInterface::class)->makePartial();
        $this->controller = new AdminController(
            $this->productRepo,
            $this->categoryRepo,
            $this->orderRepo,
            $this->userRepo
        );
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->controller);
        parent::tearDown();
    }

    public function testIndex()
    {
        $this->productRepo->shouldReceive('getAll')->andReturn($this->products);
        $this->orderRepo->shouldReceive('getAll')->andReturn($this->orders);
        $this->userRepo->shouldReceive('getAll')->andReturn($this->users);
        $this->categoryRepo->shouldReceive('getAll')->andReturn($this->categories);
        $this->orderRepo->shouldReceive('getStatistic')->andReturn([]);

        $view = $this->controller->index();
        
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('admin.index', $view->getName());
        $this->assertArrayHasKey('data', $view->getData());
        $this->assertArrayHasKey('year', $view->getData());
        $this->assertArrayHasKey('chartData', $view->getData());
    }
}
