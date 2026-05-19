<?php

namespace App\Http\Requests\users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateuserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user=$this->route('user');
        $id=is_object($user)? $user->id : $user;
      return [
            'name'=>'sometimes|string|min:5',
            'email'=> 'sometimes|email|unique:users,email,'.$id,
            'password'=>'sometimes|min:8|confirmed'
        ];
    }
}
