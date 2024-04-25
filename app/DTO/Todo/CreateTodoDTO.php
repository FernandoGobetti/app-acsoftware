<?php

namespace App\DTO\Todo;

use App\Http\Requests\TodoRequest;

class CreateTodoDTO
{
    public function __construct(
        public string $name,
        public string $status,
        public string $description
    ) {
    }

    public static function makeFromRequest(TodoRequest $request): self
    {
        return new self(
            $request->name,
            $request->status,
            $request->description
        );
    }
}
