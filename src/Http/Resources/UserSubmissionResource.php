<?php

namespace EscolaLms\AssignWithoutAccount\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSubmissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'status' => $this->status,
            'url' => $this->accessUrl->url,
            'modelable_id' => $this->accessUrl->modelable_id,
            'modelable_type' => $this->accessUrl->modelable_type,
            'created_at' => $this->created_at
        ];
    }
}
