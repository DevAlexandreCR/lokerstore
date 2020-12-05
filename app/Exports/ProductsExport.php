<?php

namespace App\Exports;

use App\Interfaces\ProductsInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport extends DefaultValueBinder implements
    FromCollection,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithCustomValueBinder,
    WithMultipleSheets,
    WithColumnFormatting,
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
            trans('products.reference'),
            trans('products.name'),
            trans('products.description'),
            trans('products.stock'),
            trans('products.cost'),
            trans('products.price'),
            trans('actions.enable'),
            'Id ' . trans('products.category'),
            trans('products.category'),
            trans('fields.tags'),
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
            $product->cost,
            $product->price,
            ($product->is_active) ? trans('messages.yes') : trans('messages.no'),
            $product->category->id,
            $product->category->name,
            $tagsString,
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
            new SizesExport(),
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'D' => 90,
            'F' => 10,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->getFill()
            ->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('E75858'));
        $sheet->getStyle('A1:K1')->getBorders()
            ->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A1:K1')->getFont()
            ->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle('A1:K1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F2:G1000')->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
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
     * @return string
     */
    public function title(): string
    {
        return trans('fields.products');
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

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_CURRENCY_USD,
            'G' => NumberFormat::FORMAT_CURRENCY_USD
        ];
    }
}
