<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\Blog\Article\StoreArticleRequest;
use App\Http\Requests\Blog\Article\UpdateArticleRequest;
use App\Http\Resources\Blog\Article\ArticleCollection;
use App\Http\Resources\Blog\Article\ArticleResource;
use App\Http\Resources\ErrorResource;
use App\Services\Contracts\Article\ArticleServiceInterface;
use Throwable;

class ArticleController extends Controller
{
    /**
     * Service instance.
     */
    protected ArticleServiceInterface $service;

    /**
     * Initialize the service instance.
     *
     * @param ArticleServiceInterface $service
     */
    public function __construct(ArticleServiceInterface $service)
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

            $articles = $this->service->getAllPaginated(request()->per_page);

            return new ArticleCollection($articles);
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreArticleRequest $request)
    {
        try {

            $article = $this->service->store($request->validated());

            return new ArticleResource($article);
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Article $article)
    {
        try {

            $article = $this->service->show($article);

            return new ArticleResource($article);
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        try {

            $article = $this->service->update($article, $request->validated());

            return new ArticleResource($article);
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function destroy(Article $article)
    {
        try {

            $this->service->destroy($article);

            return response()->noContent();
            
        } catch (Throwable $error) {
            
            return new ErrorResource($error);
        }
    }
}
