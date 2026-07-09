<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'name' => ['required','min:3','max:255'],
            'prenom' => ['required','min:3','max:255'],
            'email' => ['required','email','min:9','max:255'],
            'password' => ['required','min:8','max:16'],
            'phone' => ['required','min:9','max:16','regex:/^(?:\+243|0)\d{8,9}$/'],
            'password_confirmation' => ['required','same:password']
        ];
    }
}
