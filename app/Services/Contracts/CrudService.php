<?php

namespace App\Services\Contracts;

use App\Models\User;

abstract class CrudService implements CrudServiceInterface
{
    /**
     * Repository instance.
     */
    protected Repository $repo;

    /**
     * User model instance.
     */
    protected User $user;

    /**
     * Initialize with repository instance
     *
     * @param Repository $repo
     */
    public function __construct(Repository $repo)
    {
        $this->repo = $repo;

        return $this;
    }

    /**
     * Set user model instance.
     *
     * @param User $user
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get all resources in paginated form
     *
     * @return Illuminate\Contracts\Pagination\Paginator
     */
    public function getAllPaginated(int $perPage = null)
    {
        return $this->repo->getAllPaginated($perPage);
    }

    /**
     * Store a new resource in storage.
     *
     * @param array $data
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    /**
     * Retrieve an existed resource from storage.
     *
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function show($resource)
    {
        return $this->repo->show($resource);
    }

    /**
     * Update an existed resource in storage.
     *
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @param array $data
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function update($resource, array $data)
    {
        return $this->repo->update($resource, $data);
    }

    /**
     * Delete an existed resource in storage.
     *
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function destroy($resource)
    {
        return $this->repo->destroy($resource);
    }
}