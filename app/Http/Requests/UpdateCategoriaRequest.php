<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'nombre_categoria' => 'sometimes|required|string|max:255',
            'descripcion_categoria' => 'sometimes|required|string|max:255'
        ];
    }
}