<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * Paginate per page number.
     */
    protected const PAGINATE_PER_PAGE = 10;

    /**
     * Model instance.
     */
    protected $model;

    /**
     * Return the model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Set model instance.
     *
     * @return self
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get all resources as paginated.
     *
     * @param integer $perPage
     * @return Illuminate\Contracts\Pagination\Paginator
     */
    public function getAllPaginated(int $perPage)
    {
        $perPage = $perPage ?: self::PAGINATE_PER_PAGE;

        return $this->model()->paginate($perPage);
    }

    /**
     * Create a new resource.
     *
     * @param array $data
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->model()->create($data);
    }

    /**
     * Retrieve an existed resource from storage.
     *
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function show($resource)
    {
        if ($this->isModelBindedOrId($resource))
            return $this->model()->findOrFail($resource->id);
        
        return $this->model()->findOrFail($resource);
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
        if ($this->isModelBindedOrId($resource))
            return $this->doUpdate($this->model()->findOrFail($resource->id), $data);
            
        return $this->doUpdate($this->model()->findOrFail($resource), $data);
    }

    /**
     * Do update query with the given resource.
     *
     * @param Illuminate\Database\Eloquent\Model $resource
     * @param array $data
     * @return false|Illuminate\Database\Eloquent\Model
     */
    protected function doUpdate($resource, array $data)
    {
        if ($resource->update($data))
            return $resource;

        return false;
    }

    /**
     * Delete an existed resource from storage.
     * 
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function destroy($resource)
    {
        if ($this->isModelBindedOrId($resource))
            return $this->model()->findOrFail($resource->id)->delete();
            
        return $this->model()->findOrFail($resource)->delete();
    }

    /**
     * Check if given resource is an ID or model binded.
     *
     * @param int|Illuminate\Database\Eloquent\Model $resource
     * @return boolean
     */
    protected function isModelBindedOrId($resource)
    {
        if ($resource instanceof Model)
            return true;

        return false;
    }
}