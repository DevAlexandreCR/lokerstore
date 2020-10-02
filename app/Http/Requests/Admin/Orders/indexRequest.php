<?php

namespace App\Http\Requests\Admin\Orders;

use App\Models\Order;
use App\Constants\Orders;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class indexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('viewAny', Order::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'     =>  ['string', 'max:50', 'nullable'],
            'status'    =>  ['string', Rule::in(Orders::getAllStatus()), 'nullable'],
            'date'      =>  ['date', 'nullable']
        ];
    }
}
