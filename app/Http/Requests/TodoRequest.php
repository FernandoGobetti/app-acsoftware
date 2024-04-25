<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
            'name' => ['required', 'min:3'],
            'description' => ['required','min:3'],
            'status' => ['in:Y,N']
        ];
    }

    public function messages()
    {
        $this->sanetize();

        return [
            'name.required' => 'The NAME field is mandatory.',
            'name.min' => 'The NAME field needs at least :min characters.',
            'description.min' => 'The DESCRIPTION field needs at least :min characters.',
            'description.required' => 'The DESCRIPTION field is mandatory.',
            'status.in' => "The STATUS field only accepts Y or N."
        ];
    }

    private function sanetize()
    {
        $data = array_map( 'strip_tags', $this->all());
        $this->replace($data);
    }
}
