<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'is_completed' => $this->is_completed,
            'created_at' => $this->created_at,
        ];
    }
}
