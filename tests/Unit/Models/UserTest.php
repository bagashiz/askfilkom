<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Test the attribute types of the User model.
     *
     * @return void
     */
    public function test_user_table_attributes(): void
    {
        $user = new User();

        $this->assertSame('user', $user->getTable());
        $this->assertSame('id_user', $user->getKeyName());

        $this->assertSame([
            'username',
            'email',
            'password',
            'nama',
            'is_admin',
        ], $user->getFillable());

        $this->assertSame([
            'password',
        ], $user->getHidden());

        $this->assertSame([
            'id_user' => 'int',
            'is_admin' => 'boolean',
            'email_verified_at' => 'timestamp',
        ], $user->getCasts());
    }
}
