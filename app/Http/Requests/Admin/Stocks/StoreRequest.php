<?php

namespace App\Http\Requests\Admin\Stocks;

use App\Models\Stock;
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
        return Gate::allows('create', Stock::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer'],
            'color_id' => ['required', 'integer'],
            'size_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
