<?php

namespace App\Http\Requests\Roles;

use App\Constants\Admins;
use App\Constants\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user(Admins::GUARDED)->hasPermissionTo(Permissions::EDIT_ROLES);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => ['string', 'max:20', 'unique:roles'],
            'permissions' => ['array']
        ];
    }
}
