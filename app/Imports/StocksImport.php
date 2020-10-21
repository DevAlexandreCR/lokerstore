<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class StocksImport implements ShouldQueue, OnEachRow, WithChunkReading, WithStartRow
{

    /**
     * @param Row $row
     */
    public function onRow(Row $row): void
    {
        $rows = $row->toArray();

        Stock::updateOrCreate([
            'id' => $rows[0]
        ],[
            'product_id' => $rows[1],
            'color_id' => $rows[2],
            'size_id' => $rows[4],
            'quantity' => $rows[7]
        ]);
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
}
