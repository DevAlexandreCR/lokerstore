<?php

namespace App\Exports;

use App\Models\TypeSize;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SizesExport implements
    FromCollection,
    WithTitle,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithColumnWidths,
    WithCustomStartCell,
    WithEvents
{
    use RegistersEventListeners;

    private array $sizes;
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return TypeSize::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('fields.id'),
            trans('fields.name'),
            null,
            trans('fields.id'),
            trans('fields.name'),
            'ID ' . trans('fields.type_size'),

        ];
    }

    /**
     * @param TypeSize $typeSize
     * @return array
     */
    public function map($typeSize): array
    {
        $this->sizes = [];
        $row = [
            [],
            [
                $typeSize->id,
                $typeSize->name,
                '--->',
            ],
        ];
        $typeSize->sizes()->each(function ($size) {
            $this->sizes[] = [
                null,
                null,
                null,
                $size->id,
                $size->name,
                $size->type->id,
            ];
        });

        return array_merge($row, $this->sizes);
    }

    /**
     * @param Worksheet $sheet
     * @throws Exception
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        $sheet->setMergeCells(['A1:C1', 'D1:F1']);
        $sheet->getStyle('A1:C1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:C1')->getFill()->setStartColor(new Color(Color::COLOR_GREEN));
        $sheet->getStyle('D1:F1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('D1:F1')->getFill()->setStartColor(new Color(Color::COLOR_DARKGREEN));
        $sheet->getStyle('A2:F2')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A2:F2')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A1:F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:F2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('E2:E1000')->getFill()->setFillType(Fill::FILL_NONE);
        optional($sheet->getCell('A1'))->setValue(trans('fields.type_size'));
        optional($sheet->getCell('D1'))->setValue(trans('products.size'));
        optional($sheet->getRowDimension(1))->setRowHeight(30);
        $sheet->getProtection()->setPassword(config('app.name'));
        $sheet->getProtection()->setSheet(true);

        return [
            1    => [
                'font' => [
                    'bold' => true,
                    'size' => 13,
                ],
            ],
            2    => [
                'font' => [
                    'bold' => true,
                    'size' => 13,
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('products.size');
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'C' => 5,
        ];
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A2';
    }
    public static function afterSheet(AfterSheet $event): void
    {
        $workSheet = $event->getSheet()->getDelegate();
        $columnIterator = $workSheet->getColumnIterator('A', 'A');

        foreach ($columnIterator as $column) {
            if ($column->getColumnIndex() === 'A') {
                foreach ($column->getCellIterator('3') as $cell) {
                    if (!is_null($cell->getValue())) {
                        $row = $cell->getRow();
                        $workSheet->getStyle('A' . $row . ':F' . $row)->getFill()->setFillType(Fill::FILL_SOLID);
                        $workSheet->getStyle('A' . $row . ':F' . $row)->getFill()->setStartColor(new Color('CACAFF'));
                    }
                }
            }
        }
    }
}
