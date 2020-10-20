<?php

namespace App\Exports;

use App\Models\Stock;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StocksExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{

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
            $stock->product->id,
            $stock->color->name,
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
            trans('Color'),
            trans('Type size'),
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
        $sheet->setSelectedCells('A1:F1' );
        $sheet->getStyle($sheet->getSelectedCells())->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($sheet->getSelectedCells())->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle($sheet->getSelectedCells())->getFont()->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle($sheet->getSelectedCells())->getFill()->setStartColor(new Color('8C8C8C'));
        $sheet->getStyle($sheet->getSelectedCells())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($sheet->getSelectedCells())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
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
}
