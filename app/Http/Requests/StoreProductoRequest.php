<?php

namespace App\Http\Requests;

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
}