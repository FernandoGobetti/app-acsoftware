<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identify' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
            'dt_created' => Carbon::make($this->created_at)->format('Y-m-d')
        ];
    }
}
