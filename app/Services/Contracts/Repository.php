<?php

namespace App\Services\Contracts;

abstract class Repository
{
    /**
     * Return the model instance.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    abstract public function model();
}