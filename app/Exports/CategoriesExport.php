<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
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
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class CategoriesExport  implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles,
    ShouldAutoSize, WithColumnWidths, WithCustomStartCell, WithEvents
{
    use RegistersEventListeners;

    private array $subCategories;

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Category::primaries();
    }

    /**
     * @return array
     */
    public function headings(): array
    {

        return [
            trans('ID'),
            trans('Name'),
            null,
            trans('ID'),
            trans('Name'),
            trans('Category'),
        ];
    }

    /**
     * @param Category $category
     * @return array
     */
    public function map($category): array
    {
        $this->subCategories = [];
        $row = [
            [],
            [
                $category->id,
                $category->name,
                '--->'
            ]
        ];
        $category->children()->each( function ($subCategory)  {
            $this->subCategories[] = [
                null,
                null,
                null,
               $subCategory->id,
               $subCategory->name,
               $subCategory->id_parent,
            ];
        });
        return array_merge($row, $this->subCategories);
    }

    /**
     * @param Worksheet $sheet
     * @return array
     * @throws Exception
     */
    public function styles(Worksheet $sheet): array
    {
        $sheet->setMergeCells(['A1:C1', 'D1:F1']);
        $sheet->getStyle('C2:C1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D1:F1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('D1:F1')->getFill()->setStartColor(new Color(Color::COLOR_DARKRED));
        $sheet->getStyle('A1:C1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:C1')->getFill()->setStartColor(new Color(Color::COLOR_DARKYELLOW));
        $sheet->getStyle('A2:F2')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A2:F2')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A1:F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:F2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        optional($sheet->getCell('A1'))->setValue(trans('Category'));
        optional($sheet->getCell('D1'))->setValue('Sub-' . trans('Category'));
        optional($sheet->getRowDimension(1))->setRowHeight(30);
        return [
            1    => [
                'font' => [
                    'bold' => true,
                    'size' => 13
                ],
            ],
            2    => [
                'font' => [
                    'bold' => true,
                    'size' => 13
                ],
            ]
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('Categories');
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'C' => 20
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
                        $workSheet->getStyle('A' . $row . ':F' . $row)->getFill()->setStartColor(new Color('B2B2B2'));
                    }
                }
            }
        }
    }
}
