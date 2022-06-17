<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\Comment;
use App\Models\Order;
use Tests\Unit\ModelTestCase;

class UserTest extends ModelTestCase
{
    protected $user;

    protected function initModel()
    {
        return new User();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'fullname',
            'phone',
            'email',
            'password',
        ];

        $hidden = [
            'password',
            'remember_token',
        ];

        $casts = [
            'email_verified_at' => 'datetime',
            'id' => 'int',
        ];

        $this->runConfigurationAssertions(
            $this->model,
            [
                'table' => 'users',
                'fillable' => $fillable,
                'hidden' => $hidden,
                'casts' => $casts,
            ]
        );
    }

    public function testRoleRelation()
    {
        $relation = $this->model->role();
        $related = new Role();
        $key = 'role_id';

        $this->assertBelongsToRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }

    public function testCommentRelation()
    {
        $relation = $this->model->comments();
        $related = new Comment();
        $key = 'user_id';

        $this->assertHasManyRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }

    public function testOrderRelation()
    {
        $relation = $this->model->orders();
        $related = new Order();
        $key = 'user_id';

        $this->assertHasManyRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }

    public function testGetUnreadNotificationAttribute()
    {
        $this->user = new User();
        $this->assertIsNumeric($this->user->unread_notification);
    }
}
