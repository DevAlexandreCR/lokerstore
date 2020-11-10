<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Traits\StylizeReportExport;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class StockReport implements
    FromCollection,
    WithTitle,
    WithHeadings,
    WithStyles,
    WithColumnFormatting,
    ShouldAutoSize,
    WithEvents
{

    use RegistersEventListeners;

    private Collection $stocks;

    public function __construct(Collection $stocks)
    {
        $this->stocks = $stocks;
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return $this->stocks;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('Category'),
            trans('Cost'),
            trans('Price'),
            trans('Difference'),
            trans('Quantity'),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet): void
    {
        $sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:E1')->getFill()->setStartColor(new Color(Color::COLOR_RED));
        $sheet->getStyle('A1:E1')->getFont()
            ->setColor(new Color(Color::COLOR_WHITE))->setBold(true);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('Stock report');
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_CURRENCY_USD,
            'C' => NumberFormat::FORMAT_CURRENCY_USD,
            'D' => NumberFormat::FORMAT_CURRENCY_USD,
            'E' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public static function afterSheet(AfterSheet $event): void
    {
        StylizeReportExport::stylizeGrid($event);
    }
}
