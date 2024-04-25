<?php

namespace App\Repositories;

use App\DTO\Todo\CreateTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use stdClass;

class TodoEloquentORM implements TodoRepositoryInterface
{
    public function __construct(protected Todo $model)
    {

    }

    public function getAll(string $filter = null): array
    {
        return $this->model->where(function($query) use ($filter){
            if($filter){
                $query->where('name', 'like',"%{$filter}%");
                $query->orWhere('description', 'like', "%{$filter}%");
            }
        })->get()->toArray();
    }
    public function findOne(string $id): stdClass|null
    {
        $todo = $this->model->find($id);

        if(!$todo){
            return null;
        }

        return (object) $todo->toArray();
    }
    public function delete(string|int $id): void
    {
        $this->model->findOrFail($id)->delete();
    }
    public function new(CreateTodoDTO $dto): stdClass
    {
        $todo = $this->model->create((array) $dto);

        return (object) $todo->toArray();
    }
    public function update(UpdateTodoDTO $dto): stdClass|null
    {
        if (!$todo = $this->model->find($dto->id)){
            return null;
        }
        $todo->update((array) $dto);
        return (object) $todo->toArray();
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model->where(function($query) use ($filter){
            if($filter){
                $query->where('name', 'like', "%{$filter}%");
                $query->orWhere('description', 'like', "%{$filter}%");
            }
        })->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }
}
