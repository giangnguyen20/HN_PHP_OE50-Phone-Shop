<?php

namespace Tests\Unit\Http;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use App\Notifications\OrderNotifications;
use App\Http\Controllers\OrderAdminController;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderAdminControllerTest extends TestCase
{
    protected $orderRepo;
    protected $userRepo;
    protected $controller;
    protected $orders;
    protected $users;
    protected $order;
    protected $user;
    protected $orderNotification;

    public function setUp() : void
    {
        parent::setUp();
        $this->orders = Order::factory()->count(10)->make();
        $this->users = User::factory()->count(10)->make();
        $this->orderRepo = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->userRepo = Mockery::mock(UserRepositoryInterface::class)->makePartial();
        $this->controller = new OrderAdminController(
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
        $this->orderRepo->shouldReceive('getAllWithUsers')->andReturn([]);

        $view = $this->controller->index();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('admin.order.index', $view->getName());
        $this->assertArrayHasKey('orders', $view->getData());
    }

    public function testEdit()
    {
        $id = 1;
        $this->order = Order::factory()->make([
            'user_id' => 1,
            'total_price' => 50000,
            'address' => 'ha noi',
            'phone' => '0987654321',
            'status' => '1',
            'note' => 'oke',
        ]);
        $this->user = User::factory()->make([
            'id' => 1,
            'fullname' => 'abc',
            'phone' => '0987654321',
            'email' => 'abc@gmail.com',
            'password' => '12345678',
        ]);

        $this->orderRepo->shouldReceive('getOrderById')->with($id)
            ->andReturn($this->order);
        $this->userRepo->shouldReceive('getUser')->with($this->order['user_id'])
            ->andReturn($this->user);
        $this->orderRepo->shouldReceive('getOrderProductByOrderId')->with($this->order['id'])
            ->andReturn([]);

        $view = $this->controller->edit($id);

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('admin.order.edit', $view->getName());
        $this->assertArrayHasKey('order_product', $view->getData());
        $this->assertArrayHasKey('user', $view->getData());
        $this->assertArrayHasKey('order', $view->getData());
    }

    public function testUpdate()
    {
        $id = 1;
        $notification_id = 1;
        $attribute = [
            'status' => '2',
        ];
        $this->order = Order::factory()->make([
            'id' => 1,
            'user_id' => 1,
            'total_price' => 50000,
            'address' => 'ha noi',
            'phone' => '0987654321',
            'status' => '1',
            'note' => 'oke',
        ]);
        $this->user = User::factory()->make([
            'id' => 1,
            'fullname' => 'abc',
            'phone' => '0987654321',
            'email' => 'abc@gmail.com',
            'password' => '12345678',
        ]);

        $request = new Request($attribute);
        $this->orderRepo->shouldReceive('update')->with($id, $attribute)
            ->andReturn(true);
        $this->orderRepo->shouldReceive('getOrderById')->with($id)
            ->andReturn($this->order);

        $data = [
            'id' => $this->order['id'],
            'status' => $this->order['status'],
        ];
        $this->userRepo->shouldReceive('getUser')->with($this->order['user_id'])
            ->andReturn($this->user);
        $this->userRepo->shouldReceive('setNotification')->with($this->order['user_id'], $data)
            ->andReturn(true);
        $this->userRepo->shouldReceive('getIdNotificationWithUser')->with($this->order['user_id'])
            ->andReturn($notification_id);
        $data['notification_id'] = $notification_id;
        
        Mockery::mock(NotificationEvent::class, [
            $this->user['id'],
            $data,
        ])->makePartial();
        
        $this->controller->update($request, $id);

        $this->assertArrayHasKey('messages', session()->all());
    }

    public function testReadNotificationSuccess()
    {
        $id = 1;
        $data = [
            'id' => 1,
            'status' => 4,
        ];
        $this->order = Order::factory()->make([
            'user_id' => 1,
            'total_price' => 50000,
            'address' => 'ha noi',
            'phone' => '0987654321',
            'status' => '1',
            'note' => 'oke',
        ]);
        $this->user = User::factory()->make([
            'id' => 1,
            'fullname' => 'abc',
            'phone' => '0987654321',
            'email' => 'abc@gmail.com',
            'password' => '12345678',
        ]);

        $this->userRepo->shouldReceive('markAsReadtNotificationById')->with($id)
            ->andReturn([]);
        $this->userRepo->shouldReceive('getDataNotificationById')->with($id)
            ->andReturn($data['id']);
        $this->orderRepo->shouldReceive('getOrderById')->with($data['id'])
            ->andReturn($this->order);
        $this->userRepo->shouldReceive('getUser')->with($this->order['user_id'])
            ->andReturn($this->user);
        $this->orderRepo->shouldReceive('getOrderProductByOrderId')->with($this->order['id'])
            ->andReturn([]);
        $view = $this->controller->readNotification($id);

        $this->assertInstanceOf(View::class, $view);
        
        $this->assertEquals('user.cart.order_detail', $view->getName());
        $this->assertArrayHasKey('order', $view->getData());
        $this->assertArrayHasKey('user', $view->getData());
        $this->assertArrayHasKey('order_product', $view->getData());
    }

    public function testReadNotificationFail()
    {
        $id = 1;

        $response =  $this->controller->readNotification($id);

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testReadAllNotificationSuccess()
    {
        $this->userRepo->shouldReceive('markAsReadtAllNotification')
            ->andReturn(true);

        $url = URL::previous();
        $response = $this->controller->readAllNotification();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals($response->getTargetUrl(), $url);
    }

    public function testReadAllNotificationFail()
    {
        $this->userRepo->shouldReceive('markAsReadtAllNotification')
            ->andReturn(false);
        $response =  $this->controller->readAllNotification();

        $this->assertEquals(302, $response->getStatusCode());
    }
}
