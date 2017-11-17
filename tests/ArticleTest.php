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

    public function testArticleDeletion()
    {
        $user = factory(App\User::class, 'admin')->make();

        $this->actingAs($user)
            ->visit('/article/list')
            ->post('/article/delete', ['id' => '5'])
            ->seeJson([
                'success' => true
            ]);

        $this->assertResponseOk(true);
    }

    public function testArticleUpdate()
    {
        $user = factory(App\User::class, 'admin')->make();

        $this->actingAs($user)
            ->visit('/article/edit/1')
            ->type('titleUnit', 'title')
            ->type('slugUnit', 'slug')
            ->select('1', 'category')
            ->type('editorSlug', 'editor')
            ->press('Update')
            ->seePageIs('article/list')
            ->see('Article updated');

        $this->assertResponseOk(true);
    }
}
