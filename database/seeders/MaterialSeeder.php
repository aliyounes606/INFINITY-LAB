<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            'CCM',
            'CCM over implant',
            'Core zircon HT',
            'Core zircon preshaded',
            'Core zircon AMANN GIRRBACH',
            'Cut back zircon HT',
            'Cut back zircon preshaded',
            'Cut back zircon AMANN GIRRBACH',
            'Cut back zircon multi layer',
            'Full zircon HT',
            'Full zircon preshaded',
            'Full zircon multi layer',
            'Full zircon multi layer AMANN GIRRBACH',
            'Full zircon multi layer over implant',
            'Full zircon multi layer over implant AMANN GIRRBACH',
            'Layered zircon',
            'Layered zircon over implant',
            'Milling',
            'Glaze',
            'Metal',
            'implant',
            'Gram',
            'Small bar',
            'Medium bar',
            'Gig bar',
            'Extract I Bar',
            'Partial print',
            'Ortho print',
            'Attachment print',
            'Model print',
            'Half model print',
            'PMMA',
            'Gingiva print',
            'Surgical guide',
            'Partial',
            'Denture',
            'Ortho',
            'Veneer Emax',
            'Core Veneer Emax',
            'Full veneer zircon',
            'Core veneer zircon',
            'Wax',
            'Bite splint',
            'Telescopic crown',
        ];

        foreach ($materials as $name) {
            Material::create([
                'name' => $name,
                'price' => null,
                'status' => 'Unavailable',
            ]);
        }
    }
}
