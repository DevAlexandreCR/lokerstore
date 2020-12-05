<?php

namespace App\Http\Requests\Admin\Orders;

use App\Models\Order;
use App\Constants\Payers;
use App\Constants\Payments;
use Illuminate\Validation\Rule;
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
        return Gate::allows('create', Order::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'amount'        => ['required', 'numeric', 'min:0'],
            'details'       => ['required', 'array'],
        ];

        if ($this->get('details')) {
            foreach ($this->get('details') as $key => $val) {
                $rules['details.' . $key . '.stock_id'] = 'required|numeric|exists:stocks,id';
                $rules['details.' . $key . '.quantity'] = 'required|numeric|min:0';
            }
        }

        return $rules;
    }
}
