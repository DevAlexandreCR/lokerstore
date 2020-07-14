<?php

namespace App\Http\Requests\Products;

use App\Adapters\Products\DataRequestAdapter;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:100', 'min:3'],
            'description' => ['string', 'max:250', 'min:10'],
            'stock' => ['integer'],
            'price' => ['float'],
            'is_active' => ['boolean']
        ];
    }

    public function validationData()
    {
        return DataRequestAdapter::transform($this->all());
    }
}
