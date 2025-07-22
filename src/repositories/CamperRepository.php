<?php

namespace App\repositories;

interface CamperRepository {
    public function findById(int $id): ?object;
    public function getAll(): array;
    public function create(array $data): ?object;
    public function update(array $data, int $id): ?object;
    public function delete(array $args,int $id): object;
}