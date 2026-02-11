<?php

namespace Database\Seeders;

use App\Models\Shade;
use Illuminate\Database\Seeder;

class ShadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shades = [
            'BL1',
            'BL2',
            'BL3',
            'BL4',

            'B1',
            'B2',
            'B3',
            'B4',

            'A1',
            'A2',
            'A3',
            'A3.5',
            'A4',

            'C1',
            'C2',
            'C3',
            'C4',

            'D2',
            'D3',
            'D4',
        ];

        foreach ($shades as $shade) {
            Shade::firstOrCreate([
                'name' => $shade
            ]);
        }
    }
}