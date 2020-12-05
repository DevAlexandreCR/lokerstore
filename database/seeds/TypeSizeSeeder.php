<?php


namespace Database\Seeders;

use App\Models\TypeSize;
use Illuminate\Database\Seeder;

class TypeSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $types = ['Zapatos', 'Prendas-Superiores', 'Prendas-Inferiores', 'Especial'];

        foreach ($types as $type) {
            factory(TypeSize::class)->create([
                'name' => $type,
            ]);
        }
    }
}
