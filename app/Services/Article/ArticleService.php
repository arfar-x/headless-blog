<?php

namespace App\Services\Article;

use App\Services\Contracts\Article\ArticleServiceInterface;
use App\Services\Contracts\CrudService;
use App\Services\Contracts\Repository;
use Illuminate\Support\Facades\Auth;

class ArticleService extends CrudService implements ArticleServiceInterface
{

    /**
     * Initialize with repository instance
     *
     * @param Repository $repo
     */
    public function __construct(Repository $repo)
    {
        $this->repo = $repo;

        $this->setUser(Auth::user());

        $queryBuilder = $this->user->articles();

        $this->repo->setModel($queryBuilder);

        return $this;
    }
}