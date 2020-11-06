<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonthlyReportsExport implements FromCollection, WithTitle, WithStartRow, WithHeadings
{
    use Exportable;

    private array $metrics;

    public function __construct(array $metrics)
    {
        $this->metrics = $metrics;
    }
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return collect($this->metrics);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('Date'),
            trans('Day'),
            trans('Order No'),
            trans('Seller'),
            trans('Category'),
            trans('Reference'),
            trans('Product'),
            trans('Cost'),
            trans('Price'),
            trans('Quantity'),
            trans('Price sale'),
            trans('Paid'),
            trans('Payment method')
        ];
    }

//    /**
//     * @param mixed $row
//     * @return array
//     */
//    public function map($row): array
//    {
//        return [];
//    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('Monthly report');
    }
}
