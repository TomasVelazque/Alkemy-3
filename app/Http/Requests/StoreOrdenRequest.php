<?php

namespace App\Http\Requests;

use App\DTO\StoreOrdenDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrdenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'carrito_id' => 'required|exists:carritos,id',
            'direccion_envio' => 'required|string|max:255',
            'metodo_pago' => 'required|string|max:255'
        ];
    }

    public function toDTO(): StoreOrdenDTO 
    {
        return new StoreOrdenDTO(
            carrito_id: (int) $this->input('carrito_id'),
            direccion_envio: (string) $this->input('direccion_envio'),
            metodo_pago: (string) $this->input('metodo_pago'),
        );
    }
}
