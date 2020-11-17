<?php

namespace App\Http\Requests\Admin\Payments;

use App\Models\Payment;
use App\Constants\Payers;
use App\Constants\Payments;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Payment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'order_id'      => ['required', 'exists:orders,id'],
            'method'        => ['required', 'string', Rule::in(Payments::getMethods())],
            'document_type' => ['string', Rule::in(Payers::toArray())],
            'document'      => ['nullable', 'string', 'max:12', 'min:6'],
            'name'          => ['nullable', 'string', 'max:50', 'min:3'],
            'last_name'     => ['nullable', 'string', 'max:12', 'min:3'],
            'email'         => ['nullable', 'email'],
            'phone'         => ['nullable', 'string', 'max:12', 'min:6'],
            'amount'        => ['nullable', 'numeric'],
        ];
    }
}
