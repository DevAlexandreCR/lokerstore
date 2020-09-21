<?php

namespace App\Http\Requests\Roles;

use App\Constants\Admins;
use App\Constants\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user(Admins::GUARDED)->hasPermissionTo(Permissions::CREATE_ROLES);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:15', 'unique:roles'],
        ];
    }
}
