<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name'          => ['string', 'max:100', 'min:3', 'required'],
            'description'   => ['string', 'min:50', 'max:300'],
            'stock'         => ['integer'],
            'price'         => ['string', 'required|regex:/^\d*(\.\d{1.2})?$/'],
            'id_category'   => ['integer'],
            'tags'          => ['required', 'array'],
            'photos'        => ['required', 'array'],
            'is_active'     => ['boolean']
        ];
    }
}
