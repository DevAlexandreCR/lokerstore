<?php

namespace App\Http\Requests\Api\Products;

use Illuminate\Support\Facades\Gate;

class UpdateRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'reference'     => ['required', 'integer', 'max:100000', 'min:1'],
            'name'          => ['required', 'string', 'max:50', 'min:3'],
            'description'   => ['required', 'string', 'min:10', 'max:300'],
            'cost'          => ['required', 'numeric'],
            'price'         => ['required', 'numeric'],
            'id_category'   => ['required', 'integer', 'exists:categories,id'],
            'tags'          => ['required', 'array', 'exists:tags,name'],
        ];
    }
}
