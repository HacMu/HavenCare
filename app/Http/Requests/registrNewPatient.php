<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registrNewPatient extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'hasta_tc' => ['required','unique:patients', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'hasta_tel' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'hasta_dt' => ['required', 'date'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',  //
        ];
    }
    public function messages(){
        return [
            'hasta_tc' => 'This ID number is already exists',
        ];
    }
}
