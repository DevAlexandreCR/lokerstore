<?php

namespace App\Imports;

use App\Interfaces\StocksInterface;
use App\Models\ErrorImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class StocksImport implements
    ShouldQueue,
    OnEachRow,
    WithChunkReading,
    WithStartRow,
    SkipsOnFailure,
    WithValidation,
    SkipsOnError
{
    private StocksInterface $stocks;

    public function __construct(StocksInterface $stocks)
    {
        $this->stocks = $stocks;
    }
    /**
     * @param Row $row
     */
    public function onRow(Row $row): void
    {
        $rows = $row->toArray();

        $this->stocks->create([
            'id'           => $rows[0],
            'reference'    => $rows[1],
            'color_id'     => $rows[2],
            'size_id'      => $rows[4],
            'quantity'     => $rows[7],
        ]);
    }

    /**
     * @param Failure ...$failures
     * @return void
     */
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            ErrorImport::create([
                'import'    => trans('products.inventory'),
                'row'       => $failure->row(),
                'attribute' => $failure->attribute(),
                'value'     => implode(', ', $failure->values()),
                'errors'    => implode(', ', $failure->errors()),
            ]);
        }
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
     * @return array
     */
    public function customValidationAttributes(): array
    {
        return [
            '0' => trans('fields.id'),
            '1' => trans('fields.product'),
            '2' => trans('fields.color_id'),
            '3' => trans('products.colorr'),
            '4' => trans('fields.size_id'),
            '5' => trans('fields.type_size'),
            '6' => trans('products.size'),
            '7' => trans('fields.quantity'),
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.0' => ['integer', 'min:0'],
            '*.1' => ['integer', 'min:0', 'max:100000', 'exists:products,reference'],
            '*.2' => ['required', 'integer', 'exists:colors,id'],
            '*.3' => ['required', 'string'],
            '*.4' => ['required', 'integer', 'exists:sizes,id'],
            '*.5' => ['required', 'string', 'exists:type_sizes,name'],
            '*.6' => ['required', 'max:10'],
            '*.7' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * @param Throwable $e
     * @return void
     */
    public function onError(Throwable $e): void
    {
        logger()->channel('daily')->info('errors' . $e->getMessage());
    }
}
