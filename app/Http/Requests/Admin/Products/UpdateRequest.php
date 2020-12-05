<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
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
            'reference'     => ['required', 'integer', 'min:1', 'max:999999'],
            'name'          => ['required', 'string', 'max:100', 'min:3'],
            'description'   => ['required', 'string', 'min:30', 'max:300'],
            'cost'          => ['required', 'numeric'],
            'price'         => ['required', 'numeric'],
            'id_category'   => ['required', 'integer'],
            'tags'          => ['required', 'array'],
            'delete_photos' => ['array'],
            'photos'        => ['array'],
        ];
    }
}
