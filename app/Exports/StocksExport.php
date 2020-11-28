<?php

namespace App\Exports;

use App\Models\Stock;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StocksExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithTitle,
    WithEvents
{
    use RegistersEventListeners;

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Stock::all();
    }

    /**
     * @param Stock $stock
     * @return array
     */
    public function map($stock): array
    {
        return [
            $stock->id,
            $stock->product->reference,
            $stock->color->id,
            $stock->color->name,
            $stock->size->id,
            $stock->size->type->name,
            $stock->size->name,
            $stock->quantity,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            trans('fields.product'),
            trans('fields.color_id'),
            trans('products.color'),
            trans('fields.size_id'),
            trans('fields.type_size'),
            trans('products.size'),
            trans('products.stock'),
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('products.inventory');
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFill()
            ->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('8C8C8C'));
        $sheet->getStyle('A1:H1')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A1:H1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2:G10000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        optional($sheet->getRowDimension(1))->setRowHeight(30);

        return [
            1    => [
                'font' => [
                    'bold' => true,
                    'size' => 13,
                ],
            ],
        ];
    }

    /**
     * @param AfterSheet $event
     */
    public static function afterSheet(AfterSheet $event): void
    {
        $workSheet = $event->getSheet()->getDelegate();
        $rowIterator = $event->getSheet()->getDelegate()->getRowIterator(2, 1000);

        foreach ($rowIterator as $row) {
            $index = $row->getRowIndex();
            if ($index % 2 === 1) {
                $workSheet->getStyle('A' . $index . ':H' . $index)
                    ->getFill()->setFillType(Fill::FILL_SOLID);
                $workSheet->getStyle('A' . $index . ':H' . $index)
                    ->getFill()->setStartColor(new Color('F2F2F2'));
            }
        }
    }
}
