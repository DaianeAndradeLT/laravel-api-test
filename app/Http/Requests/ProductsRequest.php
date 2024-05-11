<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|string',
            'category' => 'required|string',
            'external_id' => 'optional|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O campo título é obrigatório',
            'title.string' => 'O campo título deve ser um texto',
            'price.required' => 'O campo preço é obrigatório',
            'price.numeric' => 'O campo preço deve ser um número',
            'description.required' => 'O campo descrição é obrigatório',
            'description.string' => 'O campo descrição deve ser um texto',
            'image.required' => 'O campo imagem é obrigatório',
            'image.string' => 'O campo imagem deve ser um texto',
            'category.required' => 'O campo categoria é obrigatório',
            'category.string' => 'O campo categoria deve ser um texto',
            'external_id.integer' => 'O campo external_id deve ser um número inteiro',
            ];
    }
}
