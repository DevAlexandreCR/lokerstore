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
     */
    public function run()
    {
        factory(Product::class, 100)->create();
        $tags = Tag::all();

        Product::inRandomOrder()->each(function ($product) use ($tags) {
            $product->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
            factory(Photo::class, rand(1, 2))->create([
                'product_id' => $product->id
            ]);
        });
    }
}
