<?php

namespace App\Http\Requests\Api\Stocks;

use App\Http\Requests\Api\Products\StoreRequest;
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
        return Gate::allows('update', $this->stock);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'color'     => 'required|string|exists:colors,name',
            'type_size' => 'required|string|exists:type_sizes,name',
            'size'      => 'required|string|exists:sizes,name',
            'quantity'  => 'required|integer|min:1',
        ];
    }
}
