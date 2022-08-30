<?php

namespace Tests\Unit\Blog;

use App\Models\Article;
use Tests\HasUser;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use HasUser;

    /**
     * Get articles as paginated Json object.
     *
     * @return void
     */
    public function testGetPaginatedArticles()
    {
        $paginatePerPage = rand(1, 10);
        
        $response = $this->actingAs($this->user)
            ->getJson(route('articles.index') . "?per_page=$paginatePerPage");

        $response->assertOk()
            ->assertJsonStructure([
                "articles" => [/* ... */],
                "links" => [/* ... */],
                "meta" => [/* ... */],
            ])
            ->assertJsonPath("meta.per_page", $paginatePerPage);
    }

    /**
     * An article can be sotred.
     *
     * @return void
     */
    public function testStoreNewArticle()
    {
        $newArticle = [
            "title" => fake()->words(10, true),
            "body" => fake()->text(rand(100, 500))
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('articles.store'), $newArticle);

        $response->assertCreated()
            ->assertJsonStructure([
                "title", "body"
            ]);
    }

    /**
     * Get an existed article from storage.
     *
     * @return void
     */
    public function testShowAnArticleById()
    {
        $articleId = 1;

        $response = $this->actingAs($this->user)
            ->getJson(route('articles.show', $articleId));

        $article = Article::findOrFail($articleId)->toArray();

        $response->assertOk()
            ->assertJsonStructure([
                "title", "body"
            ])
            ->assertJson($article);
    }

    /**
     * Update an existing article.
     *
     * @return void
     */
    public function testUpdateAnExistingArticle()
    {
        $articleId = $this->user->articles()->first()->id;

        $updatedArticle = [
            "title" => fake()->words(5, true),
            "body" => fake()->text()
        ];

        $response = $this->actingAs($this->user)
            ->patchJson(route('articles.update', $articleId), $updatedArticle);

        $article = Article::findOrFail($articleId)->toArray();

        $response->assertOk()
            ->assertJsonStructure([
                "title", "body"
            ])
            ->assertJson($article);
    }

    /**
     * Delete an existing article from storage.
     *
     * @return void
     */
    public function testDeleteAnExistingArticle()
    {
        $articleId = $this->user->articles()->first()->id;

        $response = $this->actingAs($this->user)
            ->deleteJson(route('articles.destroy', $articleId));

        $response->assertNoContent();
    }
}
