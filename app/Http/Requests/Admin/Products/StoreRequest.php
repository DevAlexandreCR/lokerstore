<?php

namespace App\Http\Requests\Admin\Products;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'reference'     => ['required', 'integer', 'min:1', 'max:999999', 'unique:products,reference'],
            'name'          => ['required', 'string', 'max:100', 'min:3'],
            'description'   => ['required', 'string', 'min:10', 'max:255'],
            'cost'          => ['required', 'numeric'],
            'price'         => ['required', 'numeric'],
            'id_category'   => ['required', 'integer'],
            'tags'          => ['required', 'array'],
            'photos'        => ['required', 'array'],
        ];
    }
}
