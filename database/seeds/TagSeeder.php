<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class)->create([
            'name' => 'Hombre'
        ]);
        factory(Tag::class)->create([
            'name' => 'Mujer'
        ]);
    }
}
