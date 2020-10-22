<?php

namespace App\Exports;

use App\Models\Stock;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class StocksExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithTitle,
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
            $stock->product->name,
            $stock->color->id,
            $stock->color->name,
            $stock->size->id,
            $stock->size->type->name,
            $stock->size->name,
            $stock->quantity
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            trans('Product'),
            trans('Color id'),
            trans('Color'),
            trans('Size') . 'id',
            trans('Type-Size'),
            trans('Size'),
            trans('Stock'),
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('Stocks');
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:H1')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A1:H1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle('A1:H1')->getFill()->setStartColor(new Color('8C8C8C'));
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2:G10000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        optional($sheet->getRowDimension(1))->setRowHeight(30);

        return [
            1    => [
                'font' => [
                    'bold' => true,
                    'size' => 13
                ],
            ]
        ];
    }

    public static function afterSheet(AfterSheet $event)
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
