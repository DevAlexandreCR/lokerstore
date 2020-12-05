<?php

namespace App\Http\Requests\Admin\Products;

use App\Helpers\Products\ProductRequestHelper;
use Illuminate\Foundation\Http\FormRequest;

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
            'orderBy'       => ['nullable', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function validationData(): array
    {
        return ProductRequestHelper::transform($this->all());
    }
}
