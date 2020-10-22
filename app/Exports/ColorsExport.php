<?php

namespace App\Exports;

use App\Models\Color;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Style\Color as Colors;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ColorsExport extends DefaultValueBinder implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles,
    ShouldAutoSize, WithCustomValueBinder
{

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Color::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('Id'),
            trans('Name'),
            trans('Translate'),
            trans('Code'),
            trans('Color'),
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('Colors');
    }

    /**
     * @param Color $color
     * @return array
     */
    public function map($color): array
    {
        return [
            $color->id,
            $color->name,
            trans($color->name),
            $color->code,
            $color->code
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->setSelectedCells('A1:E1' );
        $sheet->getStyle($sheet->getSelectedCells())->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($sheet->getSelectedCells())->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle($sheet->getSelectedCells())->getFont()->setColor(new Colors(Colors::COLOR_WHITE));
        $sheet->getStyle($sheet->getSelectedCells())->getFill()->setStartColor(new Colors(Colors::COLOR_DARKBLUE));
        $sheet->getStyle($sheet->getSelectedCells())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($sheet->getSelectedCells())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        optional($sheet->getRowDimension(1))->setRowHeight(30);
        $sheet->getProtection()->setPassword(config('app.name'));
        $sheet->getProtection()->setSheet(true);

        return [
            1    => [
                'font' => [
                    'bold' => true,
                    'size' => 13
                ],
            ]
        ];
    }

    /**
     * @param Cell $cell
     * @param mixed $value
     * @return bool
     */
    public function bindValue(Cell $cell, $value): bool
    {
        if ($cell->getColumn() === 'E') {
            $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID);
            $cell->getStyle()->getFill()->setStartColor(new Colors(substr($value, 1)));
            $cell->getStyle()->getFont()->setColor(new Colors(substr($value, 1)));
            $cell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        return parent::bindValue($cell,  $value);
    }
}
