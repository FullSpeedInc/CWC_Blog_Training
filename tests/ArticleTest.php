<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test successful category creation
     *
     * @return void
     */
    public function testArticleCreation()
    {
        $this->visit('/')
            ->see('Username')
            ->see('Password')
            ->type('admin', 'username')
            ->type('password', 'password')
            ->press('Submit')
            ->visit('/article/list')
            ->visit('/article/create')
            ->type('admin', 'title')
            ->type('password', 'slug')
            ->select('1', 'category')
            ->press('Save');

        $this->assertResponseOk(true);
    }
}
