<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $primaries_categories = ['Ropa', 'Zapatos', 'Deportes', 'Accesorios'];

        foreach ($primaries_categories as $category) {
            factory(Category::class)->create([
                'name' => $category,
                'id_parent' => null
            ]);
        }
        factory(Category::class, 10)->create();
    }
}
