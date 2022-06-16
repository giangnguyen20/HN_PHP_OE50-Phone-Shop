<?php

namespace Tests\Unit\Notification;

use Tests\TestCase;
use App\Notifications\OrderNotifications;

class OrderNotificationsTest extends TestCase
{
    protected $notification;
    protected $data;

    public function setUp() : void
    {
        parent::setUp();
        $data = [
            'id' => 1,
            'status' => 4,
        ];
        $this->notification = new OrderNotifications($data);
    }

    public function tearDown() : void
    {
        unset($this->data);
        unset($this->notification);
        parent::tearDown();
    }

    public function testVia()
    {
        $this->assertEquals(
            ['database'],
            $this->notification->via(User::class)
        );
    }

    public function testToArray()
    {
        $result = $this->notification->toArray($this->data);

        $this->assertIsArray($result);
    }
}
