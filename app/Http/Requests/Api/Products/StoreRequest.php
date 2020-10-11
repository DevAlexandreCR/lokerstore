<?php

namespace App\Http\Requests\Api\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'name'          => ['required', 'string', 'max:50', 'min:3'],
            'description'   => ['required', 'string', 'min:10', 'max:300'],
            'price'         => ['required', 'numeric'],
            'id_category'   => ['required', 'integer', 'exists:categories,id'],
            'tags'          => ['required', 'array', 'exists:tags,name'],
            'stocks'        => ['required', 'array'],
            'photos'        => ['required', 'array', 'min:1'],
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

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status' => [
                'status' => 'failed',
                'reason' => 'The given data was invalid',
                'code'   => 422,
            ],
            'errors' => $validator->errors()->all()
        ], 422));
    }

    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(response()->json([
            'status' => [
                'status' => 'failed',
                'reason' => 'User is not authorized',
                'code'   => 403,
            ]
        ], 403));
    }
}
