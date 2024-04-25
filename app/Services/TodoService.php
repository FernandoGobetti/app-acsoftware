<?php

namespace App\Services;

use App\DTO\Todo\CreateTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Repositories\TodoRepositoryInterface;
use stdClass;
class TodoService
{
    public function __construct(protected TodoRepositoryInterface $repository)
    {
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null)
    {
        return $this->repository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter
        );
    }

    public function getAll(string $filter = null): array
    {
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }

    public function delete(string|int $id): void
    {
        $this->repository->delete($id);
    }

    public function new(CreateTodoDTO $dto): stdClass
    {
        return $this->repository->new($dto);
    }

    public function update(UpdateTodoDTO $dto): stdClass|null
    {
        return $this->repository->update($dto);
    }
}
