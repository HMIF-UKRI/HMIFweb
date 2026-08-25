<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DashboardFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'period_id'     => ['nullable', 'exists:periods,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'time_range'    => ['nullable', 'in:7d,30d,90d,1y,all'],
            'start_date'    => ['nullable', 'date'],
            'end_date'      => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }
}
