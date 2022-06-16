<?php

namespace Tests\Unit\MailTest;

use Mockery;
use App\Models\User;
use App\Models\Order;
use App\Mail\SendMail;
use PHPUnit\Framework\TestCase;

class SendMailTest extends TestCase
{
    protected $report;
    protected $users;
    protected $orders;

    public function setUp(): void
    {
        parent::setUp();
        $this->users = Mockery::mock(User::class)->makePartial();
        $this->orders = Mockery::mock(Order::class)->makePartial();
        $this->report = new SendMail(
            $this->users,
            $this->orders,
        );
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testBuild()
    {
        $response = $this->report->build();
        $this->assertInstanceOf(SendMail::class, $response);
    }
}
