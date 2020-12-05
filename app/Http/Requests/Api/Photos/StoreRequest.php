<?php

namespace App\Http\Requests\Api\Photos;

use App\Http\Requests\Api\Products\StoreRequest as Request;

class StoreRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'photos'     => ['required', 'array'],
            'photos.*'   => ['base64image']
        ];
    }
}
