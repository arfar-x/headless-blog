<?php

namespace App\Services\Comment;

use App\Models\Article;
use App\Services\Contracts\Comment\CommentServiceInterface;
use App\Services\Contracts\CrudService;
use App\Services\Contracts\Repository;

class CommentService extends CrudService implements CommentServiceInterface
{
    /**
     * Initialize with repository instance
     *
     * @param Repository $repo
     */
    public function __construct(Repository $repo)
    {
        $this->repo = $repo;

        $commentsQueryBuilder = Article::findOrFail(request()->article)->comments();

        $this->repo->setModel($commentsQueryBuilder);

        return $this;
    }
}