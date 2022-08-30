<?php

namespace App\Services\Contracts;

use App\Models\User;

interface RepositoryInterface
{
    /**
     * Return the model instance.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function model();

    /**
     * Set the user model that the resource belongs to.
     *
     * @return App\Models\User|Illuminate\Contracts\Auth\Authenticatable
     */
    // public function user();

    /**
     * Retrieve resources as paginated.
     *
     * @return Illuminate\Contracts\Pagination\Paginator
     */
    public function getAllPaginated(int $perPage = null);

    /**
     * Get resources that belong to user model.
     *
     * @param User $user
     * @param integer $perPage
     * @return Illuminate\Contracts\Pagination\Paginator
     */
    public function getAllPaginatedForUser(User $user, int $perPage = null);

    /**
     * Create a new resource in the storage.
     *
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);
}