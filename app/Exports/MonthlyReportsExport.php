<?php

namespace App\Exports;

use App\Constants\Orders;
use App\Repositories\Metrics;
use App\Traits\StylizeReportExport;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MonthlyReportsExport implements
    FromCollection,
    WithTitle,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithStyles,
    ShouldAutoSize,
    WithEvents,
    WithMultipleSheets
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
        return collect($this->metrics->monthlyReport($this->date, Orders::STATUS_SUCCESS));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('reports.monthly');
    }

    /**
     * @param AfterSheet $event
     * @throws Exception
     */
    public static function afterSheet(AfterSheet $event): void
    {
        $colDimension = self::stylizeGrid($event);
        if ((int)$colDimension < 3) {
            return;
        }
        $sheet = $event->getSheet()->getDelegate();
        $colIterator = $sheet->getColumnIterator('L', 'P');

        $totalCost = 0;
        $totalPrice = 0;
        $totalPriceSale = 0;
        $totalPaid = 0;
        $totalProductsSold = 0;
        foreach ($colIterator as $col) {
            foreach ($col->getCellIterator(2) as $cell) {
                switch ($col->getColumnIndex()) {
                    case 'L':
                        $totalCost += $cell->getValue();
                        break;
                    case 'M':
                        $totalPrice += $cell->getValue();
                        break;
                    case 'N':
                        $totalProductsSold += $cell->getValue();
                        break;
                    case 'O':
                        $totalPriceSale += $cell->getValue();
                        break;
                    case 'P':
                        if ($cell->getRow() > 2) {
                            if (self::getCell($sheet, $cell) === self::getCell($sheet, $cell, -1)) {
                                break;
                            }
                            $totalPaid += $cell->getValue();
                        }
                        break;
                }
            }
        }
        $colDimension++;
        $sheet->setCellValue('K' . $colDimension, trans('orders.total'));
        $sheet->setCellValue('L' . $colDimension, $totalCost);
        $sheet->setCellValue('M' . $colDimension, $totalPrice);
        $sheet->setCellValue('N' . $colDimension, $totalProductsSold);
        $sheet->setCellValue('O' . $colDimension, $totalPriceSale);
        $sheet->setCellValue('P' . $colDimension, $totalPaid);

        $sheet->getStyle('A' . $colDimension . ':Q' . $colDimension)
            ->getFont()->setBold(true);
        $sheet->getStyle('A' . $colDimension . ':Q' . $colDimension)
            ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        $sheet->getStyle('N' . $colDimension)
            ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            $this,
            new OrdersUncompletedExport($this->metrics, $this->date),
            new StockReport(collect($this->metrics->getStockReport())),
        ];
    }

    private static function getCell(Worksheet $sheet, Cell $cell, int $offset = 0)
    {
        return $sheet->getCell('C' . ($cell->getRow() - $offset))->getValue();
    }
}
