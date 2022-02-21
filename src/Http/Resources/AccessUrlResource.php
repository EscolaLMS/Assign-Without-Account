<?php

namespace EscolaLms\AssignWithoutAccount\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccessUrlResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'modelable_id' => $this->modelable_id,
            'modelable_type' => $this->modelable_type,
        ];
    }
}
