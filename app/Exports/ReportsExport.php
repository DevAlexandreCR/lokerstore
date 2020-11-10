<?php

namespace App\Exports;

use Illuminate\View\View;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Exception;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class ReportsExport extends DefaultValueBinder implements
    FromView,
    ShouldAutoSize,
    WithColumnFormatting,
    WithCustomValueBinder,
    WithStyles,
    WithStartRow,
    WithEvents,
    WithTitle
{
    use Exportable;
    use RegistersEventListeners;

    private array $metrics;
    private float $totalMan = 0;
    private float $totalManPercent = 0;
    private float $totalWoman = 0;
    private float $totalWomanPercent = 0;
    private float $totalSold = 0;

    public function __construct(array $metrics)
    {
        $this->metrics = $metrics;
    }

    public function view(): View
    {
        return view('admin.exports.reports', [
            'categories' => $this->reorderCategories(),
            'monthly' => $this->reorderMonthly(),
            'totalMan' => $this->totalMan,
            'totalManPercent' => $this->totalManPercent,
            'totalWomanPercent' => $this->totalWomanPercent,
            'totalWoman' => $this->totalWoman,
            'totalSold' => $this->totalSold,
            'uncompleted' => $this->reorderUncompleted()
        ]);
    }

    /**
     * Reorder list of categories to report
     * @return Collection
     */
    public function reorderCategories(): Collection
    {
        $categories = new Collection();
        $collection = collect($this->metrics);
        foreach ($collection->get('categories') as $category) {
            $date = explode('-', $category->date);
            $month = $date[0] . '-' . $date[1];
            if ($categories->has($month)) {
                if ($categories->get($month)->amount < $category->amount) {
                    $categories->put($month, $category);
                }
            } else {
                $categories->put($month, $category);
            }
        }
        return $categories;
    }

    /**
     * @return Collection
     */
    public function reorderUncompleted(): Collection
    {
        $uncompleted = new Collection();
        $metrics = collect($this->metrics);
        foreach ($metrics->get('uncompleted') as $order) {
            $date = explode('-', $order->date);
            $month = $date[0] . '-' . $date[1];
            $order->date = $month;
            $uncompleted->push($order);
        }
        return $uncompleted;
    }

    /**
     * Reorder list of orders to report
     * @return Collection
     */
    public function reorderMonthly(): Collection
    {
        $orders = new Collection();
        $collection = collect($this->metrics);

        foreach ($collection->get('monthly') as $order) {
            $date = explode('-', $order->date);
            $month = $date[0] . '-' . $date[1];
            if ($orders->has($month)) {
                $o = $orders->get($month);
                $o->genderF = $order->gender;
                $o->totalF = $order->amount ?? 0;
                $orders->put($month, $o);
            } else {
                $order->totalF = 0;
                $orders->put($month, $order);
            }
        }

        foreach ($orders->all() as $key => $order) {
            $tSold = $order->totalF + $order->amount;
            $order->totalFPercent = $order->totalF / $tSold;
            $order->amountPercent = $order->amount / $tSold;
            $this->totalMan += $order->amount;
            $this->totalWoman += $order->totalF;
            $orders->put($key, $order);
        }
        $this->totalSold = $this->totalMan + $this->totalWoman;
        $this->totalManPercent = $this->totalMan  / $this->totalSold;
        $this->totalWomanPercent = $this->totalWoman  / $this->totalSold;

        return $orders;
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_PERCENTAGE_00,
            'C' => NumberFormat::FORMAT_CURRENCY_USD,
            'D' => NumberFormat::FORMAT_PERCENTAGE_00,
            'E' => NumberFormat::FORMAT_CURRENCY_USD,
            'G' => NumberFormat::FORMAT_CURRENCY_USD,
        ];
    }

    /**
     * @param Cell $cell
     * @param mixed $value
     * @return bool
     */
    public function bindValue(Cell $cell, $value): bool
    {
        return parent::bindValue($cell, $value);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 5;
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     * @throws Exception
     */
    public function styles(Worksheet $sheet): void
    {
        $sheet->mergeCells('A1:G4');
        $sheet->getCell('A1')->setValue(trans('General sales report'));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A5:G5')->getFill()->setFillType(Fill::FILL_SOLID)
            ->setStartColor(new Color(Color::COLOR_RED));
        $sheet->getStyle('A5:G5')->getFont()->setBold(true)->setSize(12)
            ->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle('A5:G5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
    }

    /**
     * @param AfterSheet $event
     */
    public static function afterSheet(AfterSheet $event): void
    {
        $sheet = $event->sheet->getDelegate();
        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator('A', 'B') as $cell) {
                if ($cell->getValue() === trans('Totals')) {
                    $sheet->getStyle('A' . $row->getRowIndex() . ':G' . $row->getRowIndex())
                        ->getFont()->setBold(true);
                    self::setHeadersTables($sheet, $row->getRowIndex(), trans('Category more sold for month'));
                }
                if ($cell->getValue() === trans('Status')) {
                    self::setHeadersTables($sheet, $row->getRowIndex() - 4, trans('Uncompleted orders'));
                }
            }
        }
    }

    /**
     * Customize headers of tables of sheet
     * @param Worksheet $sheet
     * @param int $row
     * @param string $tableName
     */
    public static function setHeadersTables(Worksheet $sheet, int $row, string $tableName): void
    {
        try {
            $sheet->getCell('A' . ($row + 2))->setValue($tableName);
            $sheet->mergeCells('A' . ($row + 2) . ':C' . ($row + 3));
        } catch (Exception $e) {
            logger()->error($e->getMessage());
        }

        $sheet->getStyle('A' . ($row + 2))->getFont()
            ->setBold(true)->setSize(12);
        $sheet->getStyle('A' . ($row + 2))->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . ($row + 4) . ':C' . ($row + 4))
            ->getFont()->setBold(true)->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle('A' . ($row + 4) . ':C' . ($row + 4))->getFill()
            ->setFillType(Fill::FILL_SOLID)->setStartColor(new Color(Color::COLOR_RED));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('General sales report');
    }
}
