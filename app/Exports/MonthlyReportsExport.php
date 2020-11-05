<?php

namespace App\Exports;

use App\Models\Metric;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonthlyReportsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Metric::all();
    }
}
