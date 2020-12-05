<?php

namespace App\Http\Requests\Admin\Admins;

use App\Models\Admin\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Admin::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:50'],
            'email'     => ['required', 'string', 'max:50', 'unique:admins'],
            'password'  => ['required', 'string'],
            'status'    => ['boolean'],
            'role'      => ['integer'],
        ];
    }
}
