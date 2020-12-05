<?php

namespace App\Http\Requests\Api\Products;

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
        $rules = [
            'reference'     => ['required', 'integer', 'max:100000', 'min:1'],
            'name'          => ['required', 'string', 'max:50', 'min:3'],
            'description'   => ['required', 'string', 'min:10', 'max:300'],
            'cost'          => ['required', 'numeric'],
            'price'         => ['required', 'numeric'],
            'id_category'   => ['required', 'integer', 'exists:categories,id'],
            'tags'          => ['required', 'array', 'exists:tags,name'],
            'stocks'        => ['required', 'array'],
            'photos'        => ['required', 'array', 'min:1'],
            'photos.*'      => ['base64image']
        ];
        if ($this->get('stocks')) {
            foreach ($this->get('stocks') as $key => $val) {
                $rules['stocks.' . $key . '.color'] = 'required|string|exists:colors,name';
                $rules['stocks.' . $key . '.size'] = 'required|array';
                $rules['stocks.' . $key . '.size.type'] = 'required|string|exists:type_sizes,name';
                $rules['stocks.' . $key . '.size.size'] = 'required|string|exists:sizes,name';
                $rules['stocks.' . $key . '.quantity'] = 'required|integer|min:1';
            }
        }

        return $rules;
    }
}
