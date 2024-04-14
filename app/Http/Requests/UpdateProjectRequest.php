<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//Helpers
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;// impostato a True per CRUD Edit
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //ritorniamo lo stesso che c'è in StoreProjectRequest
                "name"=> ['required', 'max:255'],
                "image"=> ['nullable', 'image'],
                "description"=> ['nullable','string'],
                "due_date"=> ['nullable', 'date'],
                "status"=> ['required', Rule::in(['pending' , 'in_progress', 'completed'])],
        ];
    }
}
