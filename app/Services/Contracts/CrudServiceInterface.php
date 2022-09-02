<?php

namespace App\Services\Contracts;

use App\Models\User;

interface CrudServiceInterface
{
    /**
     * Initialize with repository instance
     *
     * @param Repository $repo
     */
    public function __construct(Repository $repo);

    /**
     * Set user model instance.
     *
     * @param User $user
     * @return self
     */
    public function setUser(User $user);

    /**
     * Get all resources in paginated form
     *
     * @return Illuminate\Contracts\Pagination\Paginator
     */
    public function getAllPaginated(int $perPage = null);

    /**
     * Store a new resource in storage.
     *
     * @param array $data
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function store(array $data);

    /**
     * Retrieve an existed resource from storage.
     *
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function show($resource);

    /**
     * Update an existed resource in storage.
     *
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @param array $data
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function update($resource, array $data);

    /**
     * Delete an existed resource in storage.
     *
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function destroy($resource);
}