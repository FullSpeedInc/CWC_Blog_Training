<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test successful category creation
     *
     * @return void
     */
    public function testCategoryCreation()
    {
        $this->visit('/')
            ->see('Username')
            ->see('Password')
            ->type('admin', 'username')
            ->type('password', 'password')
            ->press('Submit')
            ->visit('/category/list')
            ->type(Str_random(10), 'name')
            ->press('Submit')
            ->visit('/category/list')
            ->see('Category added');

        $this->assertResponseOk(true);
    }

    public function testCategoryDeletion()
    {
        $id = DB::table('article_category')
                  ->insertGetId(
                                  array('name' => Str_random(10), 'updated_user_id' => 1)
                               );

        $this->visit('/')
            ->see('Username')
            ->see('Password')
            ->type('admin', 'username')
            ->type('password', 'password')
            ->press('Submit')
            ->visit('/category/list')
            ->post('/category/delete', ['id' => $id])
            ->seeJson([
                'success' => true
            ]);

        $this->assertResponseOk(true);
    }
}
