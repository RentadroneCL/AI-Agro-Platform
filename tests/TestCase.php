<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * User with administrator role attached.
     *
     * @var User $administrator
     */
    protected User $testAdministratorUser;

    /**
     * Gets executed before the test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->testAdministrator = User::first();
    }
}
