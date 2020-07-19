<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:100', 'min:3'],
            'description'   => ['required', 'string', 'min:30', 'max:300'],
            'stock'         => ['required', 'integer'],
            'price'         => ['required', 'numeric'],
            'id_category'   => ['required', 'integer'],
            'tags'          => ['required', 'array'],
            'delete_photos' => ['array'],
            'photos'        => ['array']
        ];
    }
}
