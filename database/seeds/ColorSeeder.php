<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $namecolors =
        [
            'WHITE'    => '#FFFFFF',
            'SILVER'   => '#C0C0C0',
            'GRAY'     => '#808080',
            'BLACK'    => '#000000',
            'RED'      => '#FF0000',
            'MAROON'   => '#800000',
            'YELLOW'   => '#FFFF00',
            'LIME'     => '#00FF00',
            'GREEN'    => '#008000',
            'AQUA'     => '#00FFFF',
            'BLUE'     => '#0000FF',
            'FUCHSIA'  => '#FF00FF',
            'PURPLE'   => '#800080',
            'PINK'     => '#FF0080',
        ];

        foreach ($namecolors as $name => $code) {
            factory(Color::class)->create([
                'name' => $name,
                'code' => $code,
            ]);
        }
    }
}
