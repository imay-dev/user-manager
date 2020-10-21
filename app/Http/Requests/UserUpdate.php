<?php

namespace App\Http\Requests;


use Illuminate\Validation\Rule;

class UserUpdate extends Request
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
        return [
            'name' => 'nullable|string',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:190',
                Rule::unique('users')->ignore($this->user),
            ],
            'password' => 'nullable|confirmed|min:6',
        ];
    }
}
