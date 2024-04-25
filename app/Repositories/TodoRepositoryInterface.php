<?php

namespace App\Repositories;

use App\DTO\Todo\CreateTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use stdClass;

interface TodoRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string|int $id): void;
    public function new(CreateTodoDTO $dto): stdClass;
    public function update(UpdateTodoDTO $dto): stdClass|null;
}
