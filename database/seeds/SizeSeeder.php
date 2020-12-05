<?php

namespace Database\Seeders;

use App\Models\Size;
use App\Models\TypeSize;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizesZapatos = ['34', '35', '36','37', '38', '39', '40', '41', '42', '43'];
        $sizesSuperir = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'];
        $sizesInferior = ['4/S', '6/S', '8/M', '10/M', '12/L', '14/XL', '16/XL', '28/S', '30/S', '32/M', '34/L', '36/XL', '38/XL'];
        $sizesEspecial = ['Unique'];

        factory(Size::class)->create([
            'name' => 'Unique',
            'type_sizes_id' => TypeSize::where('name', 'Especial')->first()->id,
        ]);

        foreach ($sizesZapatos as $size) {
            factory(Size::class)->create([
                'name' => $size,
                'type_sizes_id' => TypeSize::where('name', 'Zapatos')->first()->id,
            ]);
        }

        foreach ($sizesSuperir as $size) {
            factory(Size::class)->create([
                'name' => $size,
                'type_sizes_id' => TypeSize::where('name', 'Prendas-Superiores')->first()->id,
            ]);
        }

        foreach ($sizesInferior as $size) {
            factory(Size::class)->create([
                'name' => $size,
                'type_sizes_id' => TypeSize::where('name', 'Prendas-Inferiores')->first()->id,
            ]);
        }
    }
}
