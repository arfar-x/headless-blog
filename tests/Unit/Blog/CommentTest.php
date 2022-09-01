<?php

namespace Tests\Unit\Blog;

use App\Models\Comment;
use Tests\HasUser;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use HasUser;

    /**
     * Get comments as paginated Json object.
     *
     * @return void
     */
    public function testGetPaginatedComments()
    {
        $paginatePerPage = rand(1, 10);
        $articleId = rand(1, 10);
        
        $response = $this->actingAs($this->user)
            ->getJson(route('comments.index', $articleId) . "?per_page=$paginatePerPage");

        $response->assertOk()
            ->assertJsonStructure([
                "comments" => [/* ... */],
                "links" => [/* ... */],
                "meta" => [/* ... */],
            ])
            ->assertJsonPath("meta.per_page", $paginatePerPage);
    }

    /**
     * An comment can be sotred.
     *
     * @return void
     */
    public function testStoreNewComment()
    {
        $articleId = rand(1, 10);

        $newComment = [
            "publisher_name" => fake()->name(),
            "publisher_email" => fake()->safeEmail(),
            "body" => fake()->text(1024),
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route("comments.store", $articleId), $newComment);

        $response->assertCreated()
            ->assertJsonStructure([
                "publisher_name",
                "publisher_email",
                "body",
            ]);
    }

    /**
     * Get an existed comment from storage.
     *
     * @return void
     */
    public function testShowAnCommentById()
    {
        $articleId = 2;
        $commentId = 22;

        $response = $this->actingAs($this->user)
            ->getJson(route('comments.show', [ "article" => $articleId, "comment" => $commentId ]));

        $comment = Comment::findOrFail($commentId)->toArray();

        $response->assertOk()
            ->assertJsonStructure([
                "id",
                "article_id",
                "publisher_name",
                "publisher_email",
                "body"
            ])
            ->assertJson($comment);
    }

    /**
     * Update an existing comment.
     *
     * @return void
     */
    public function testUpdateAnExistingComment()
    {
        $commentId = $this->user->comments()->first()->id;

        $articleId = 2;
        $commentId = 22;

        $updatedComment = [
            "publisher_name" => fake()->name(),
            "publisher_email" => fake()->safeEmail(),
            "body" => fake()->text()
        ];

        $response = $this->actingAs($this->user)
            ->patchJson(route('comments.update', [ "article" => $articleId, "comment" => $commentId ]), $updatedComment);

        $comment = Comment::findOrFail($commentId)->toArray();

        $response->assertOk()
            ->assertJsonStructure([
                "id",
                "article_id",
                "publisher_name",
                "publisher_email",
                "body"
            ])
            ->assertJson($comment);
    }

    /**
     * Delete an existing comment from storage.
     *
     * @return void
     */
    public function testDeleteAnExistingComment()
    {
        $articleId = 2;
        $commentId = 23;

        $response = $this->actingAs($this->user)
            ->deleteJson(route('comments.destroy', [ "article" => $articleId, "comment" => $commentId ]));

        $response->assertNoContent();
    }
}
