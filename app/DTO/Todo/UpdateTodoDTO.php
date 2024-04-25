<?php

namespace App\DTO\Todo;

use App\Http\Requests\TodoRequest;

class UpdateTodoDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $status,
        public string $description
    )
    {
    }

    public static function makeFromRequest(TodoRequest $request, $todoOrig = null): self
    {
        if (!$request->status) {
            return new self(
                $todoOrig->id ?? $request->id,
                $request->name,
                $todoOrig->status,
                $request->description
            );
        } else {
            return new self(
                $todoOrig->id ?? $request->id,
                $request->name,
                $request->status,
                $request->description
            );
        }
    }
}
