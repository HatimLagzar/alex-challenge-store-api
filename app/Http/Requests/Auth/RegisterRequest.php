<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => ['email', 'max:100', 'required'],
            'name'     => ['string', 'max:100', 'required'],
            'password' => ['string', 'max:255', 'confirmed', 'required']
        ];
    }
}
