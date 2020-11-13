<?php

namespace App\Http\Requests\Admin\Orders;

use App\Models\Order;
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
            'method'        => ['required', 'string'],
            'document'      => ['string', 'min:5'],
            'document_type' => ['string'],
            'name'          => ['string'],
            'last_name'     => ['string'],
            'email'         => ['string', 'email'],
            'phone'         => ['string', 'regex:/(3)[0-9]{9}/'],
        ];

        if ($this->get('details')) {
            foreach ($this->get('details') as $key => $val) {
                $rules['details.' . $key . '.stock_id'] = 'required|string|exists:stocks,id';
                $rules['details.' . $key . '.quantity'] = 'required|numeric|min:0';
            }
        }

        return $rules;
    }
}
