<?php

namespace App\Services\Contracts;

interface CrudRepositoryInterface
{
    /**
     * Retrieve resources as paginated.
     *
     * @return Illuminate\Contracts\Pagination\Paginator
     */
    public function getAllPaginated(int $perPage = null);

    /**
     * Create a new resource in the storage.
     *
     * @return false|Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);
}