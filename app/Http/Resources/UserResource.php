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
            'nome' => $this->nome,
            'cargo' => [
                'id' => $this->cargo->id,
                'nome' => $this->cargo->nome,
            ],
            'email' => $this->email,
            'matricula' => $this->matricula,
            'turnos' => TurnosResource::collection($this->turnos),
            'quantidade_turnos' => $this->turnos->count(),
        ];
    }
}
