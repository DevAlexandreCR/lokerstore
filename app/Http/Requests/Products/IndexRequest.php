<?php

namespace App\Http\Requests\Products;

use App\Helpers\Products\ProductRequestHelper;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexRequest extends FormRequest
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
            'category'      => ['nullable', 'string'],
            'tags'          => ['nullable', 'array'],
            'price'         => ['nullable', 'string'],
            'sizes'         => ['nullable', 'array'],
            'colors'        => ['nullable', 'array'],
            'search'        => ['nullable', 'string'],
            'orderBy'       => ['nullable', 'string']
        ];
    }

    public function validationData()
    {
        return ProductRequestHelper::transform($this->all());
    }
}
