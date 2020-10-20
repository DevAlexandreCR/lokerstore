<?php

namespace App\Exports;

use App\Models\Product;
use App\Interfaces\ProductsInterface;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class ProductsExport extends DefaultValueBinder implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize,
    WithStyles, WithCustomValueBinder, WithMultipleSheets, WithTitle, WithColumnWidths, WithEvents
{
    use Exportable;
    use RegistersEventListeners;

    private ProductsInterface $products;

    public function __construct(ProductsInterface $products)
    {
        $this->products = $products;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->products->index();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            trans('Name'),
            trans('Description'),
            trans('Stock'),
            trans('Price'),
            trans('Enabled'),
            trans('Category'),
            trans('Tags'),
        ];
    }
    /**
     * @param Product $product
     * @return array
     */
    public function map($product): array
    {
        $tags = $product->tags()->pluck('name')->toArray();
        $tagsString = implode(', ', $tags);
        return [
            $product->id,
            $product->name,
            $product->description,
            '=SUMIFS(Stocks!F:F,Stocks!B:B,A:A)',
            $product->price,
            ($product->is_active)? 'Si' : 'No',
            $product->category->name,
            $tagsString
        ];
    }

    /**
     * @param Cell $cell
     * @param mixed $value
     * @return bool
     */
    public function bindValue(Cell $cell, $value): bool
    {
        if (in_array($cell->getColumn(), ['A', 'D', 'F'])) {
            $cell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        return parent::bindValue($cell,  $value);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            $this,
            new StocksExport(),
            new CategoriesExport(),
            new ColorsExport(),
            new SizesExport()
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'C' => 90,
            'D' => 10
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->setSelectedCells('A1:H1' );
        $sheet->getStyle($sheet->getSelectedCells())->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($sheet->getSelectedCells())->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle($sheet->getSelectedCells())->getFont()->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle($sheet->getSelectedCells())->getFill()->setStartColor(new Color('E75858'));
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

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('Products');
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
                    ->getFill()->setStartColor(new Color('FAE7E2'));
            }
        }
    }
}
