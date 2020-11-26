<?php

namespace App\Http\Requests\Admin\Admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->admin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => ['string', 'max:50'],
            'email'     => ['string', 'max:50', 'unique:admins' . $this ->id . ',id'],
            'password'  => ['string'],
            'status'    => ['boolean'],
            'roles'     => ['array'],
        ];
    }
}
