<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test successful login
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $this->visit('/')
             ->see('Username')
             ->see('Password')
             ->type('admin2', 'username')
             ->type('password', 'password')
             ->press('Submit')
             ->seePageIs('/user/list');

        $this->assertResponseOk(true);
    }

    /**
     * Test unsuccessful login
     *
     * @return void
     */
    public function testUnsuccessfulLogin()
    {
        $this->visit('/')
             ->see('Username')
             ->see('Password')
             ->type('invaliduser', 'username')
             ->type('password', 'password')
             ->press('Submit')
             ->seePageIs('/')
             ->see('Invalid login');

        $this->assertResponseOk(true);
    }

    /**
     * Test successful user registration
     *
     * @return void
     */
    public function testSuccessfulRegistration()
    {
        $user = factory(App\User::class, 'admin')->make();

        $this->actingAs($user)
             ->visit('/user/list')
             ->type('test2', 'username')
             ->type('test2', 'firstname')
             ->type('test2', 'lastname')
             ->select('0', 'role')
             ->type('password', 'password')
             ->press('Submit')
             ->seePageIs('/user/list')
             ->see('User added');

        $this->assertResponseOk(true);
    }

    /**
     * Test unsuccessful user registration
     *
     * @return void
     */
    public function testUnsuccessfulRegistration()
    {
        $user = factory(App\User::class, 'admin')->make();

        $this->actingAs($user)
            ->visit('/user/list')
            ->type('test2', 'username')
            ->type('test2', 'firstname')
            ->type('test2', 'lastname')
            ->select('0', 'role')
            ->type('password', 'password')
            ->press('Submit')
            ->dontSee('User added');

        $this->assertResponseOk(true);
    }

    /**
     * Test unsuccessful user registration
     *
     * @return void
     */
    public function testSuccessfulUpdate()
    {
        $user = factory(App\User::class, 'admin')->make();

        $this->actingAs($user)
            ->visit('/user/list')
            ->type('test2', 'username')
            ->type('test2', 'firstname')
            ->type('test2', 'lastname')
            ->select('0', 'role')
            ->type('password', 'password')
            ->press('Submit')
            ->dontSee('User added');

        $this->assertResponseOk(true);
    }
}
