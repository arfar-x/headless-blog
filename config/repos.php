<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    |
    | All services that are being used should be added here.
    | Each service should a unique key/name to be paired with its interface and repository.
    |
    */
    'services' => [
        'auth'      => App\Services\Auth\AuthService::class,
        'article'   => App\Services\Article\ArticleService::class,
        'comment'   => App\Services\Comment\CommentService::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Services' Interfaces
    |--------------------------------------------------------------------------
    |
    | For scalability, Open-closed and Dependency Inversion principles, we should
    | provide interface for each service. These interfaces are binded to the Laravel
    | IoC Container and act as an alias for each. Note that, there might be some empty
    | interfaces (Marker Interface) to determine type of the service being used by Laravel.
    | Although, it gives the ability to add new features for each service.
    | Interfaces are the starting point to bind services; whenever the interface is needed,
    | the relative service (its service) is resolved.
    |
    */
    'interfaces' => [
        'auth'      => App\Services\Contracts\Auth\AuthServiceInterface::class,
        'article'   => App\Services\Contracts\Article\ArticleServiceInterface::class,
        'comment'   => App\Services\Contracts\Comment\CommentServiceInterface::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Services' Repositories
    |--------------------------------------------------------------------------
    |
    | If the target service interacts with the database/storage, it must have a repository.
    | Actually, repositories are the layer between the service logic and database/storage
    | interactions and queries.
    |
    */
    'repositories' => [
        'auth'      => null,
        'article'   => App\Services\Article\ArticleRepository::class,
        'comment'   => App\Services\Comment\CommentRepository::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Services' dependencies while instantiating
    |--------------------------------------------------------------------------
    |
    | All services must inject their dependencies while being instantiated and constructed.
    | This means IoC Container resolves dependencies then injects them to the services.
    | This way, dependencies are usable and can be resolved easily.
    |
    */
    'dependencies' => [
        'auth' => [
            App\Services\Contracts\Auth\TokenFactoryInterface::class => App\Services\Auth\TokenFactory::class,
        ],
        'article' => App\Services\Article\ArticleRepository::class,
        'comment' => App\Services\Comment\CommentRepository::class,
    ]
];