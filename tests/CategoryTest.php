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
            ->type('somecategory', 'name')
            ->press('Submit')
            ->visit('/category/list')
            ->see('Category added');

        $this->assertResponseOk(true);
    }
}
