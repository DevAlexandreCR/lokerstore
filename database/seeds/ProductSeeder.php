<?php

use App\Models\Photo;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        factory(Product::class, 100)->create();

        Product::inRandomOrder()->each(function ($product) {
            $product->tags()->attach(
                Tag::all()->random()->id
            );

            factory(Photo::class)->create([
                'product_id' => $product->id
            ]);
        });
    }
}
