<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
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
            'nombre' => $this->nombre_producto,
            'descripcion' => $this->descripcion_producto,
            'precio' => (float)$this->precio_producto,
            'stock' => (int) $this->stock_producto,
            'disponible' => $this->stock_producto > 0,
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
            'actualizado' => $this->updated_at->format('d/m/Y'),
            'creado' => $this->created_at->format('d/m/Y'),
        ];
    }
}
