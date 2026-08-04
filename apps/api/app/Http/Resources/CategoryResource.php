<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform resource.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'public_id' => $this->public_id,

            'code' => $this->code,

            'name' => $this->name,

            'description' => $this->description,

            'active' => $this->active,

            'created_at' => optional($this->created_at)->toDateTimeString(),

            'updated_at' => optional($this->updated_at)->toDateTimeString(),

        ];
    }
}