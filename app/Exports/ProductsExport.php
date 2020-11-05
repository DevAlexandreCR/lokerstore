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

class ProductsExport extends DefaultValueBinder implements
    FromCollection,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithCustomValueBinder,
    WithMultipleSheets,
    WithTitle,
    WithColumnWidths,
    WithEvents
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
            trans('Reference'),
            trans('Name'),
            trans('Description'),
            trans('Stock'),
            trans('Cost'),
            trans('Price'),
            trans('Enabled'),
            'ID ' . trans('Category'),
            trans('Category'),
            trans('Tags')
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
            $product->reference,
            $product->name,
            $product->description,
            $product->stock,
//            '=SUMIFS(Stocks!H:H,Stocks!B:B,B:B)',
            $product->cost,
            $product->price,
            ($product->is_active)? 'Si' : 'No',
            $product->category->id,
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
        if (in_array($cell->getColumn(), ['A', 'B', 'G', 'H', 'I'])) {
            $cell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        return parent::bindValue($cell, $value);
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
            'D' => 90,
            'F' => 10
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:K1')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A1:K1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle('A1:K1')->getFill()->setStartColor(new Color('E75858'));
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:K1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
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
                $workSheet->getStyle('A' . $index . ':K' . $index)
                    ->getFill()->setFillType(Fill::FILL_SOLID);
                $workSheet->getStyle('A' . $index . ':K' . $index)
                    ->getFill()->setStartColor(new Color('FAE7E2'));
            }
        }
    }
}
