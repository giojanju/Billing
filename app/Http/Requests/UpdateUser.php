<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required'],
            'parent_id' => ['nullable'],
        ];

        if (Auth::user()->can('password-change') && !Auth::user()->can('edit-users')) {
            $rules['name'][0] = 'nullable';
            $rules['email'][0] = 'nullable';
            $rules['password'][0] = 'required';
            $rules['role_id'][0] = 'nullable';
        }

        return $rules;
    }
}
