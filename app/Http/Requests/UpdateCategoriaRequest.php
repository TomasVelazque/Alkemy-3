<?php

namespace App\Http\Requests;

use App\DTO\UpdateCategoriaDTO;
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

    public function toDTO(): UpdateCategoriaDTO
    {
        $validated = $this->validated();

        return new UpdateCategoriaDTO(
            nombre_categoria: $validated['nombre_categoria'] ?? null,
            descripcion_categoria: $validated['descripcion_categoria'] ?? null,
            providedFields: array_keys($validated),
        );
    }
}