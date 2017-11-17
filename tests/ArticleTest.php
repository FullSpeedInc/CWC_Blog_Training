<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Article;

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
        $data = Str_random(10);

        $this->visit('/')
            ->see('Username')
            ->see('Password')
            ->type('admin', 'username')
            ->type('password', 'password')
            ->press('Submit')
            ->visit('/article/list')
            ->visit('/article/create')
            ->type($data, 'title')
            ->type($data, 'slug')
            ->select('1', 'category')
            ->press('Save');

        $this->assertResponseOk(true);
    }

    public function testArticleDeletion()
    {
        $user          = factory(App\User::class, 'admin')->make();
        $articleDelete = Article::first();

        $this->actingAs($user)
            ->visit('/article/list')
            ->post('/article/delete', ['id' => $articleDelete->id])
            ->seeJson([
                'success' => true
            ]);

        $this->assertResponseOk(true);
    }

    public function testArticleUpdate()
    {
        $user          = factory(App\User::class, 'admin')->make();
        $articleUpdate = Article::first();

        $this->actingAs($user)
            ->visit('/article/edit/' . $articleUpdate->id)
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
