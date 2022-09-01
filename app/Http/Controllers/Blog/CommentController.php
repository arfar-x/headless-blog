<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\Blog\Comment\StoreCommentRequest;
use App\Http\Requests\Blog\Comment\UpdateCommentRequest;
use App\Http\Resources\Blog\Comment\CommentCollection;
use App\Http\Resources\Blog\Comment\CommentResource;
use App\Http\Resources\ErrorResource;
use App\Services\Contracts\Comment\CommentServiceInterface;
use Throwable;

class CommentController extends Controller
{
    /**
     * Service instance.
     */
    protected CommentServiceInterface $service;

    /**
     * Initialize the service instance.
     *
     * @param CommentServiceInterface $service
     */
    public function __construct(CommentServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        try {

            $comments = $this->service->getAllPaginated(request()->per_page);

            return new CommentCollection($comments);
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreCommentRequest $request)
    {
        try {

            $comment = $this->service->store($request->validated());

            return (new CommentResource($comment))->response()->setStatusCode(201);
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }

    /**
     * Display the specified resource. 
     *
     * @param  int $article
     * @param  \App\Models\Comment  $comment
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function show($article, Comment $comment)
    {
        /**
         * TODO Laravel built-in route model binding injects article id to the first parameter automatically;
         *  so it is not possible to retrieve comment as first argument, instead Laravel finds it as an
         *  article. Article ID and its comments query builder are set in CommentService and there is no need
         *  to get article ID as function argument. Fix it.
         */

        try {

            $comment = $this->service->show($comment);

            return new CommentResource($comment);
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param int $article
     * @param Comment $comment
     * @return void
     */
    public function update(UpdateCommentRequest $request, $article, Comment $comment)
    {
        try {

            $comment = $this->service->update($comment, $request->validated());

            return new CommentResource($comment);
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $article
     * @param Comment $comment
     * @return void
     */
    public function destroy($article, Comment $comment)
    {
        try {

            $this->service->destroy($comment);

            return response()->noContent();
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }
}
