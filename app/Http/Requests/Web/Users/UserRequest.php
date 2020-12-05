<?php

namespace App\Http\Requests\Web\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => ['string', 'max:100', 'min:3'],
            'lastname'  => ['string', 'max:100', 'min:3'],
            'email'     => ['string', 'email', 'max:255', 'unique:users' . $this ->id . ',id'],
            'password'  => ['string', 'min:8', 'confirmed'],
            'phone'     => ['string', 'regex:/(3)[0-9]{9}/','numeric'],
            'address'   => ['string', 'min:10'],
            'is_active' => ['boolean'],
        ];
    }
}
