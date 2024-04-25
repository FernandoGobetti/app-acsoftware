<?php

namespace App\Http\Controllers;

use App\Adapters\ApiAdapter;
use App\DTO\Todo\CreateTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function __construct(protected TodoService $service)
    {
    }

    /**
     * Route::get /api/todo
     * Lists all todo with pagination.
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function index(Request $request)
    {
        $todos = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter
        );

        return ApiAdapter::toJson($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request)
    {
        $support = $this->service->new(
            CreateTodoDTO::makeFromRequest($request)
        );

        return new TodoResource($support);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$todo = $this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, string $id)
    {
        if (!$todoOrig = $this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $todo = $this->service->update(
            UpdateTodoDTO::makeFromRequest($request, $todoOrig)
        );

        return new TodoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$todo = $this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->service->delete($id);

        return response()->json(["message" => "Deleted"], Response::HTTP_NO_CONTENT);
    }
}
