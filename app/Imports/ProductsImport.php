<?php

namespace App\Imports;

use App\Interfaces\ProductsInterface;
use App\Interfaces\StocksInterface;
use App\Models\ErrorImport;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ProductsImport implements
    ShouldQueue,
    OnEachRow,
    WithMultipleSheets,
    WithChunkReading,
    WithStartRow,
    SkipsOnError,
    WithTitle,
    SkipsOnFailure,
    WithValidation
{
    use Importable;

    private ProductsInterface $products;
    private StocksInterface $stocks;

    public function __construct(ProductsInterface $products, StocksInterface $stocks)
    {
        $this->products = $products;
        $this->stocks = $stocks;
    }

    /**
     * @param Row $row
     * @return void
     */
    public function onRow(Row $row): void
    {
        $rows = $row->toArray();

        $this->products->create([
            'reference'   => $rows[1],
            'name'        => $rows[2],
            'description' => $rows[3],
            'cost'        => $rows[5],
            'price'       => $rows[6],
            'is_active'   => $rows[7] === 'Si' ? 1 : 0,
            'id_category' => $rows[8],
            'tags'        => $rows[10],
        ]);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            $this,
            new StocksImport($this->stocks),
        ];
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param Throwable $e
     * @return void
     */
    public function onError(Throwable $e): void
    {
        logger()->channel('daily')->info('errors' . $e->getMessage());
    }

    /**
     * @param Failure ...$failures
     * @return void
     */
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            ErrorImport::create([
                'import'    => trans('fields.products'),
                'row'       => $failure->row(),
                'attribute' => $failure->attribute(),
                'value'     => implode(', ', $failure->values()),
                'errors'    => implode(', ', $failure->errors()),
            ]);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '0'  => ['integer', 'min:0'],
            '1'  => ['required', 'integer', 'min:1', 'max:100000'],
            '2'  => ['required', 'string', 'max:100'],
            '3'  => ['required', 'string', 'max:255'],
            '4'  => ['required', 'integer'],
            '5'  => ['required', 'numeric', 'min:1000'],
            '6'  => ['required', 'numeric', 'min:1000'],
            '7'  => ['required', 'string', 'in:Si,No'],
            '8'  => ['required', 'integer', 'exists:categories,id'],
            '9'  => ['required', 'string', 'max:255'],
            '10' => ['required', 'string', 'exists:tags,name'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes(): array
    {
        return [
            '0' => trans('fields.id'),
            '1' => trans('products.reference'),
            '2' => trans('products.name'),
            '3' => trans('products.description'),
            '4' => trans('products.stock'),
            '5' => trans('products.cost'),
            '6' => trans('products.price'),
            '7' => trans('actions.enabled'),
            '8' => 'Id ' . trans('products.category'),
            '9' => trans('products.category'),
            '10' => trans('fields.tags'),
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return trans('fields.products');
    }
}
