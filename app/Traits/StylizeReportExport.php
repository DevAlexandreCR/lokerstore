<?php

namespace App\Traits;

use App\Constants\Dates;
use App\Constants\Orders;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait StylizeReportExport
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('orders.date'),
            trans('validation.attributes.day'),
            trans('orders.no'),
            trans('fields.status'),
            trans('fields.seller'),
            trans('payer.payer'),
            trans('users.email'),
            trans('users.phone'),
            trans('products.category'),
            trans('products.reference'),
            trans('fields.product'),
            trans('products.cost'),
            trans('products.price'),
            trans('fields.quantity'),
            trans('products.price_sale'),
            trans('payment.paid'),
            trans('payment.method'),
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->date,
            Dates::getTranslatedDay($row->day_sale),
            $row->num_order,
            Orders::getTranslatedStatus($row->status),
            $row->seller ?? 'Online',
            $row->payer,
            $row->email_payer,
            $row->phone_payer,
            $row->category_name,
            $row->reference,
            $row->product_name,
            $row->cost,
            $row->price,
            $row->quantity,
            $row->price_sale,
            $row->paid,
            $row->method,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Q1')->getFill()
            ->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('E75858'));
        $sheet->getStyle('A1:Q1')->getBorders()
            ->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A1:Q1')->getFont()
            ->setColor(new Color(Color::COLOR_WHITE));
        $sheet->getStyle('A1:Q1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('H')
            ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
        $sheet->setAutoFilter('A1:Q1');
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
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'L' => NumberFormat::FORMAT_CURRENCY_USD,
            'M' => NumberFormat::FORMAT_CURRENCY_USD,
            'O' => NumberFormat::FORMAT_CURRENCY_USD,
            'P' => NumberFormat::FORMAT_CURRENCY_USD,
        ];
    }

    /**
     * @param AfterSheet $event
     * @return mixed
     */
    public static function stylizeGrid(AfterSheet $event)
    {
        $sheet = $event->getSheet()->getDelegate();
        $dimensions = $sheet->calculateWorksheetDimension();
        $arrayDim = explode(':', $dimensions);
        $colDimension = str_split('0' . $arrayDim[1], 2)[1];
        $rowDimension = str_split($arrayDim[1])[0];
        if ((int)$colDimension < 3) {
            return 0;
        }
        $rowIterator = $sheet->getRowIterator(2, $colDimension);

        foreach ($rowIterator as $row) {
            $index = $row->getRowIndex();
            $dim = $rowDimension . $row->getRowIndex();
            if ($index % 2 === 1) {
                $sheet->getStyle('A' . $index . ':' . $dim)
                    ->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('A' . $index . ':' . $dim)
                    ->getFill()->setStartColor(new Color('F2F2F2'));
            }
        }

        return $colDimension;
    }
}
