<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'nombre' => $this->nombre_categoria,
            'descripcion' => $this->descripcion_categoria,
            'actualizado' => $this->updated_at->format('d/m/Y'),
            'creado' => $this->created_at->format('d/m/Y')
        ];
    }
}
