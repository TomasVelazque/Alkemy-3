<?php

namespace App\Http\Requests;

use App\DTO\StoreCategoriaDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_categoria' => 'required|string|max:255',
            'descripcion_categoria' => 'required|string|max:255'
        ];
    }

    #CONVERTIMOS LOS DATOS DEL REQUEST A UN DTO
    public function toDTO(): StoreCategoriaDTO 
    {
        return new StoreCategoriaDTO(
            nombre_categoria: $this->input('nombre_categoria'),
            descripcion_categoria: $this->input('descripcion_categoria'),
        );
    }
}