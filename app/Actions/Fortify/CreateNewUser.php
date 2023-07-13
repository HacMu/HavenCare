<?php

namespace App\Actions\Fortify;
use DB;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Http\Requests\registrNewPatient;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'hasta_tc' => ['required','unique:patients', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'hasta_tel' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'hasta_dt' => ['required', 'date'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        $patient =Patient::create([
                'user_id' => DB::table('users')->where('email', '=',$input['email'])->value('id'),
                'hasta_tc' => $input['hasta_tc'],
                'hasta_adi' => $input['name'],
                'hasta_tel' => $input['hasta_tel'],
                'hasta_dt' => $input['hasta_dt'],
        ]);
        $patient->save();
        return $user;
    }
}
