<?php

namespace App\Http\Requests\Admin\Reports;

use App\Models\Metric;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('viewAny', Metric::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'from' => ['required', 'date', 'date_format:Y-m-d'],
            'to'   => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
