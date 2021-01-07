<?php

namespace Tests;

use App\User;
use Tests\CreatesApplication;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;
    use WithFaker;

    /**
     * Set up the test
     */
    public function setUp() : void
    {
        parent::setUp();
        Artisan::call('passport:install', ['-vvv' => true]);
    }

    /**
     * Authenticate user
     *
     * @param \App\User $user The user model
     * @return TestCase
     */
    public function passportActingAs(User $user)
    {
        Passport::actingAs(
            $user,
            ['authToken']
        );
        return $this;
    }

    /**
     * Reset the migrations
     */
    public function tearDown() : void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
