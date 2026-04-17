<?php

namespace App\Repositories\Contracts;

interface CltLayupRepositoryInterface
{
    public function allBySupplier($supplierId);
    public function find($id);
    public function findByNameAndSupplier($name, $supplierId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
