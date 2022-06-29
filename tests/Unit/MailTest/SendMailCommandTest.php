<?php

namespace Tests\Unit\MailTest;

use Mockery;
use App\Models\User;
use App\Models\Order;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Console\Commands\SendMailCommands;
use App\Mail\SendMail;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;

class SendMailCommandTest extends TestCase
{
    protected $command;
    protected $users;
    protected $orders;
    protected $userRepo;
    protected $orderRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->users = Mockery::mock(User::class)->makePartial();
        $this->orders = Mockery::mock(Order::class)->makePartial();
        $this->userRepo = Mockery::mock(UserRepositoryInterface::class)->makePartial();
        $this->orderRepo = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->command = new SendMailCommands(
            $this->userRepo,
            $this->orderRepo,
        );
        $this->users = User::factory()->count(10)->make();
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->command);
        parent::tearDown();
    }

    public function testHandle()
    {
        Mail::fake();
        $users = User::factory()->count(10)->make();
        $quantity = 10;
        
        $this->userRepo->shouldReceive('getAdmins')->andReturn($users);
        $this->orderRepo->shouldReceive('getTheOrderQuantity')->andReturn($quantity);

        $this->command->handle();
        Mail::assertQueued(SendMail::class, 10);
    }
}
