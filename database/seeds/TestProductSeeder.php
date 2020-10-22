<?php

use App\Models\Photo;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TestProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        factory(Product::class, 10)->create();
        $tags = Tag::all();

        Product::inRandomOrder()->each(function ($product) use ($tags) {
            $product->tags()->attach(
                $tags->random(random_int(1, 2))->pluck('id')->toArray()
            );
        });
    }
}
