<?php

namespace App\Http\Requests;

use App\Support\PlainteStatut;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlainteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('service') && ! $this->has('id_service')) {
            $this->merge(['id_service' => $this->input('service')]);
        }
    }

    public function rules(): array
    {
        $rules = [
            'id_service' => ['required', 'exists:services,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'piece_jointe' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
            'location' => ['nullable', 'string', 'max:255'],
            'priorite' => ['nullable', 'in:normale,haute,urgente'],
            'statut' => ['nullable', Rule::in(PlainteStatut::all())],
            'nom' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
        ];

        if (! auth()->check()) {
            $rules['nom'] = ['required', 'string', 'max:255'];
            $rules['contact'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }
}
