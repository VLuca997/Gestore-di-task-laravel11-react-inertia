<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ABILITATO A TRUE PER IL FORM CREATE DI PROJECT!
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //REGOLE DI VALIDAZIONE PER IL CREATE FORM DI PROJECT:

            "name"=> ['required', 'max:255'],
            "image"=> ['nullable', 'image'],
            "description"=> ['nullable','string'],
            "due_date"=> ['nullable', 'date'],
            "status"=> ['required', Rule::in(['pending' , 'in_progress', 'completed'])],
        ];
    }
}
