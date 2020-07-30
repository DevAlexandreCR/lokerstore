<?php

use App\Models\Color;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Size;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 100)->create();
        $tags = Tag::all();
        $colors = Color::all();
        $sizes = Size::all();

        Product::inRandomOrder()->each(function ($product) use ($tags, $colors, $sizes) {
    
            $product->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );

            $stock = $product->stock;
            $randomColors = rand(1, $stock);

            $residuo  = $stock % $randomColors;
            $stockColors  = intdiv($stock, $randomColors);

            for ($i=0; $i < $randomColors; $i++) { 
                $product->colors()->attach(
                    $colors->random(1)->pluck('id')->toArray(),
                    [
                        'stock' => ( ($i+1) == $randomColors)? $stockColors + $residuo : $stockColors
                    ]
                );
                $product->sizes()->attach(
                    $sizes->random(1)->pluck('id')->toArray(),
                    [
                        'stock' => ( ($i+1) == $randomColors)? $stockColors + $residuo : $stockColors
                    ]
                );
            }
            
            factory(Photo::class, rand(1, 2))->create([
                'product_id' => $product->id
            ]);
        });
    }
}
