<?php

namespace App\Repositories\Contracts;

interface SupplierRepositoryInterface
{
    public function all();
    public function paginate($perPage = 10);
    public function find($id);
    public function findByExtId($extId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
