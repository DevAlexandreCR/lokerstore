<?php

use App\Models\Product;
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
        factory(Product::class, 30)->create();
        $tags = Tag::all();

        Product::inRandomOrder()->each(function ($product) use ($tags) {
            $product->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
