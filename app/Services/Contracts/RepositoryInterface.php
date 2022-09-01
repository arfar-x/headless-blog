<?php

namespace App\Services\Contracts;

interface RepositoryInterface
{
    /**
     * Return the model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function model();

    /**
     * Set model instance.
     *
     * @return self
     */
    public function setModel($model);

    /**
     * Get all resources as paginated.
     *
     * @param integer $perPage
     * @return Illuminate\Contracts\Pagination\Paginator
     */
    public function getAllPaginated(int $perPage);

    /**
     * Create a new resource.
     *
     * @param array $data
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

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
     * Delete an existed resource from storage.
     * 
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function destroy($resource);
}