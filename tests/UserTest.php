<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//additional includes
use App\User;

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
             ->type('admin', 'username')
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
        $username = Str_random(10);
        $user     = factory(App\User::class, 'admin')->make();

        $this->actingAs($user)
             ->visit('/user/list')
             ->type($username, 'username')
             ->type('first name', 'firstname')
             ->type('last name', 'lastname')
             ->select('0', 'role')
             ->type('password', 'password')
             ->press('Submit')
             ->visit('/user/list')
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
        $user          = factory(App\User::class, 'admin')->make();
        $userAvailable = User::where(['role' => 0])->first();

        $this->actingAs($user)
            ->visit('/user/list')
            ->type($userAvailable->username, 'username')
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
        $userEdit = User::where(['role' => 0])->first();

        $response = $this->call('POST',
                                '/user/update',
                                [
                                    'id'        => $userEdit->id,
                                    'firstname' => Str_random(10),
                                    'lastname'  => Str_random(10),
                                    'role'      => 0

                                ]);

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testUserDeletion()
    {
        $user = factory(App\User::class, 'admin')->make();
        $userEdit = User::where(['role' => 0])->first();

        $this->actingAs($user)
            ->visit('/user/list')
            ->post('/user/delete', ['id' => $userEdit->id])
            ->seeJson([
                'success' => true
            ]);

        $this->assertResponseOk(true);
    }
}
