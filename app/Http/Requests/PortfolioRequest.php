<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titre' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
            'lien_portfolio' => ['required'],
            'contenu' => ['required', 'min:3'],
            'category_portfolio_id' => ['exists:category_portfolios,id'],
            'media' => ['required', 'image'],

        ];
    }
}
