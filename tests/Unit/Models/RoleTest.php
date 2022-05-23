<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use Tests\Unit\ModelTestCase;

class RoleTest extends ModelTestCase
{
    protected $role;

    protected function initModel()
    {
        return new Role();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'name',
        ];

        $this->runConfigurationAssertions(
            $this->model,
            [
                'fillable' => $fillable,
            ]
        );
    }

    public function testRoleRelation()
    {
        $relation = $this->model->users();
        $related = new User();
        $key = 'role_id';

        $this->assertHasManyRelation(
            $relation,
            $this->model,
            $related,
            $key
        );
    }
}
