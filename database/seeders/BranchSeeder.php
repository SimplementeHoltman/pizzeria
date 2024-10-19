<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;


class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sucursal 1
        Branch::create([
            'nombre' => 'Sucursal en zona 8 de Guatemala',
            'direccion' => 'Dirección de la sucursal en zona 8',
            'latitud' => 14.615040964063946,
            'longitud' => -90.52653856037149,
        ]);

        // Sucursal 2
        Branch::create([
            'nombre' => 'Sucursal en Colonia La Landívar, Guatemala',
            'direccion' => 'Dirección de la sucursal en Colonia La Landívar',
            'latitud' => 14.618594870641523,
            'longitud' => -90.53836429977162,
        ]);

        // Sucursal 3
        Branch::create([
            'nombre' => 'Sucursal en Colonia Landívar, zona 11, Guatemala',
            'direccion' => 'Dirección de la sucursal en Colonia Landívar',
            'latitud' => 14.606428644620845,
            'longitud' => -90.5506440268919,
        ]);
    }
}
