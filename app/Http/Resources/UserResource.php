<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'admin' => $this->is_admin == 1 ? true : false,
            'created_at' => $this->created_at == null ? '-' : date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at' => $this->updated_at == null ? '-' : date('d-m-Y H:i:s', strtotime($this->updated_at))
        ];
    }
}
