<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarritoRequest extends FormRequest
{
    # SETEAMOS EN TRUE
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
            #COMO AHORA USAMOS AUTHORIZATION NO LO NECESITAREMOS
            # 'user_id' => 'required|exists:users,id', 
        ];
    }
}
