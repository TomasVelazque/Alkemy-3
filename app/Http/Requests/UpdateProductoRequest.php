<?php

namespace App\Http\Requests;

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
}