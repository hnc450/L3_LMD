<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlainteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_user' => ['nullable', 'exists:users,id'],
            'id_service' => ['required', 'exists:services,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'piece_jointe' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:4096'],
            'statut' => ['in:Enregistrée,En cours,Résolue,Rejetée'],
            'location' => ['required', 'string'],
        ];
    }
}
