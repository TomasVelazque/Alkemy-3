<?php

namespace App\Http\Requests;

use App\DTO\UpdateProductoDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_producto' => 'sometimes|required|string|max:255',
            'descripcion_producto' => 'sometimes|nullable|string',
            'precio_producto' => 'sometimes|required|numeric',
            'stock_producto' => 'sometimes|required|numeric',
            'categoria_id' => 'sometimes|required|exists:categorias,id'
        ];
    }

    #FUNCION PARA CONVERTIR LOS DATOS DEL REQUEST EN UN DTO
    public function toDTO(): UpdateProductoDTO{
        
        $validated = $this->validated();

        return new UpdateProductoDTO(
            nombre_producto: $validated['nombre_producto'] ?? null,
            descripcion_producto: $validated['descripcion_producto'] ?? null,
            precio_producto: array_key_exists('precio_producto', $validated) ? (float) $validated['precio_producto'] : null,
            stock_producto: array_key_exists('stock_producto', $validated) ? (int) $validated['stock_producto'] : null,
            categoria_id: array_key_exists('categoria_id', $validated) ? (int) $validated['categoria_id'] : null,
            providedFields: array_keys($validated),
        );
    }
}