<?php

namespace App\Http\Requests;

use App\DTO\StoreProductoDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_producto' => 'required|string|max:255',
            'descripcion_producto' => 'nullable|string',
            'precio_producto' => 'required|numeric|min:0',
            'stock_producto' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id'
        ];
    }

    #CONVERTIMOS LOS DATOS DEL REQUEST A UN DTO
    public function toDTO(): StoreProductoDTO{
        return new StoreProductoDTO(
            nombre_producto: $this->input('nombre_producto'),
            descripcion_producto: $this->input('descripcion_producto'),
            precio_producto: (float) $this->input('precio_producto'),
            stock_producto: (int) $this->input('stock_producto'),
            categoria_id: (int) $this->input('categoria_id'),
        );
    }
}