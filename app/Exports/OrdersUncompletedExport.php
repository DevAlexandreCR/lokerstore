<?php

namespace App\Exports;

use App\Repositories\Metrics;
use Illuminate\Support\Collection;
use App\Traits\StylizeReportExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class OrdersUncompletedExport implements FromCollection,
    WithTitle,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithStyles,
    ShouldAutoSize,
    WithEvents
{
    use Exportable;
    use RegistersEventListeners;
    use StylizeReportExport;

    private Metrics $metrics;
    private string $date;

    public function __construct(Metrics $metrics, string $date)
    {
        $this->metrics = $metrics;
        $this->date = $date;
    }
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return collect($this->metrics->monthlyReport($this->date));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('Uncompleted orders');
    }

    /**
     * @param AfterSheet $event
     */
    public static function afterSheet(AfterSheet $event): void
    {
        self::stylizeGrid($event);
    }
}
