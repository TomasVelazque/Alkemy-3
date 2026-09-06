<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdenResource extends JsonResource
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
            'carrito' => $this->carrito_id,
            'subtotal' => $this->subtotal,
            'impuestos' => $this->impuestos,
            'total' => $this->total,
            'costo_envio' => $this->costo_envio,
            'direccion_envio' => $this->direccion_envio,
            'metodo_pago' => $this->metodo_pago,
            'confirmada' => (bool) $this->confirmada,
            'actualizado' => $this->updated_at?->format('d/m/Y'),
            'creado' => $this->created_at?->format('d/m/Y'),
        ];
    }
}
