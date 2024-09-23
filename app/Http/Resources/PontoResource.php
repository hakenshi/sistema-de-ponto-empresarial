<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PontoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'usuario' => [
              'id' => $this->usuario->id,
              'nome' => $this->usuario->nome,
              'email' => $this->usuario->email,
              'matricula' => $this->usuario->matricula,
          ],
            'data_hora_entrada' => Carbon::createFromFormat('Y-m-d H:i:s', $this->data_hora_entrada)->format('d/m/Y, H:i'),
            'data_hora_saida' => $this->data_hora_saida ?  Carbon::createFromFormat('Y-m-d H:i:s', $this->data_hora_saida)->format('d/m/Y, H:i') : null,
        ];
    }
}
