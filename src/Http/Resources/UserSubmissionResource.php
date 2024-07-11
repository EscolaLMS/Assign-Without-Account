<?php

namespace EscolaLms\AssignWithoutAccount\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSubmissionResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'email' => $this->resource->email,
            'status' => $this->resource->status,
            'morphable_id' => $this->resource->morphable_id,
            'morphable_type' => $this->resource->morphable_type,
            'created_at' => $this->resource->created_at
        ];
    }
}
