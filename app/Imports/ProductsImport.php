<?php

namespace App\Imports;

use Throwable;
use Maatwebsite\Excel\Row;
use App\Models\ErrorImport;
use App\Interfaces\ProductsInterface;
use Illuminate\Support\Facades\Cache;
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

class ProductsImport implements ShouldQueue, OnEachRow, WithMultipleSheets, WithChunkReading, WithStartRow,
    SkipsOnError, SkipsOnFailure, WithValidation
{
    use Importable;

    private ProductsInterface $products;

    public array $errors = array();

    public function __construct(ProductsInterface $products)
    {
        $this->products = $products;
    }

    /**
     * @param Row $row
     * @return void
     */
    public function onRow(Row $row): void
    {
        $rows = $row->toArray();

        $this->products->create((int)$rows[0], [
            'name' => $rows[1],
            'description' => $rows[2],
            'price' => $rows[4],
            'is_active' => $rows[5] === 'Si' ? 1 : 0,
            'id_category' => $rows[6],
            'tags' => $rows[8]
        ]);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            $this,
            new StocksImport()
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
        foreach($failures as $failure) {

            ErrorImport::create([
                'row'       => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors'    => json_encode($failure->errors(), JSON_THROW_ON_ERROR),
            ]);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.0' => ['array', 'min:0']
        ];
    }
}
