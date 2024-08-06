<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    // public static $wrap = 'comida';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'name' => $this->name,
            // 'email' => $this->user->email,
            'user' => new UserResource($this->whenLoaded('user')),
            // 'email' => $this->when($this->user->email, $this->user->email),
            // 'user' => new UserResource($this->user), // mostra um array user e dentro dele o email
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
