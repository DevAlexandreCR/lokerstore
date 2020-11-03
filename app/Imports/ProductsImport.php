<?php

namespace App\Imports;

use Throwable;
use Maatwebsite\Excel\Row;
use App\Models\ErrorImport;
use App\Interfaces\StocksInterface;
use App\Interfaces\ProductsInterface;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsImport implements
    ShouldQueue,
    OnEachRow,
    WithMultipleSheets,
    WithChunkReading,
    WithStartRow,
    SkipsOnError,
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
            'cost'        => $rows[4],
            'price'       => $rows[5],
            'is_active'   => $rows[6] === 'Si' ? 1 : 0,
            'id_category' => $rows[7],
            'tags'        => $rows[8]
        ]);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            $this,
            new StocksImport($this->stocks)
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
                'import'    => 'products',
                'row'       => $failure->row(),
                'attribute' => $failure->attribute(),
                'value'     => implode(', ', $failure->values()),
                'errors'    => implode(', ', $failure->errors())
            ]);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.0'  => ['integer', 'min:0'],
            '*.1'  => ['required','integer', 'min:1', 'max:100000'],
            '*.2'  => ['required', 'string', 'max:100'],
            '*.3'  => ['required', 'string', 'max:255'],
            '*.4'  => ['required', 'string'],
            '*.5'  => ['required', 'numeric', 'min:1000'],
            '*.6'  => ['required', 'numeric', 'min:1000'],
            '*.7'  => ['required', 'string', 'in:Si,No'],
            '*.8'  => ['required', 'integer', 'exists:categories,id'],
            '*.9'  => ['required', 'string', 'max:255'],
            '*.10' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes(): array
    {
        return [
            '0' => 'ID',
            '1' => 'Name',
            '2' => 'Description',
            '3' => 'Stock',
            '4' => 'Price',
            '5' => 'Enabled',
            '6' => 'Category id',
            '7' => 'Category',
            '8' => 'Tags'
        ];
    }
}
