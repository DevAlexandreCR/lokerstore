<?php

namespace App\Http\Requests\Api\Photos;

use App\Http\Requests\Api\Products\StoreRequest as Request;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class DestroyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('delete', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'photos'    => ['required', 'array'],
            'photos.*'  => ['required', 'integer', 'exists:photos,id'],
        ];
    }
}
