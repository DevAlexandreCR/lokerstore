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
        $sub_categories_ropa = ['Camisas', 'Blusas', 'Busos', 'Faldas', 'Vestidos', 'Shorts', 'Chaquetas', 'Pantalones', 'Jeans', 'Ropa interior'];
        $sub_categories_zapatos = ['Tennis', 'Sandalias'];
        $sub_categories_accesorios = ['Relojes', 'Gafas'];
        $sub_categories_deportes = ['Tennis Deportivos', 'Camisetas Deportivas', 'Sudaderas'];

        foreach ($primaries_categories as $category) {
            factory(Category::class)->create([
                'name' => $category,
                'id_parent' => null
            ]);
        }

        foreach ($sub_categories_ropa as $category) {
            factory(Category::class)->create([
                'name' => $category,
                'id_parent' => 1
            ]);
        }

        foreach ($sub_categories_zapatos as $category) {
            factory(Category::class)->create([
                'name' => $category,
                'id_parent' => 2
            ]);
        }

        foreach ($sub_categories_deportes as $category) {
            factory(Category::class)->create([
                'name' => $category,
                'id_parent' => 3
            ]);
        }

        foreach ($sub_categories_accesorios as $category) {
            factory(Category::class)->create([
                'name' => $category,
                'id_parent' => 4
            ]);
        }
    }
}
