<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3']
        ];
    }

    public function messages()
    {
        $this->sanetize();

        return [
            'email.required' => 'The EMAIL field is mandatory.',
            'email.email' => 'The EMAIL field is not valid.',
            'password.required' => 'The PASSWORD field is mandatory.',
            'password.min' => 'The PASSWORD field needs at least :min characters.',
        ];
    }

    private function sanetize()
    {
        $data = array_map( 'strip_tags', $this->all());
        $this->replace($data);
    }
}
