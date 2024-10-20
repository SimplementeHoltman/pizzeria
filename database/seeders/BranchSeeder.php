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
            'nombre' => 'Zona 8 de Guatemala',
            'direccion' => '40 Calle 10-02 zona 8 Guatemala, C.A Guatemala',
            'latitud' => 14.615040964063946,
            'longitud' => -90.52653856037149,
        ]);

        // Sucursal 2
        Branch::create([
            'nombre' => 'La Landívar, Guatemala, zona 7',
            'direccion' => '5-54, 6A Avenida, 9A Calle, Cdad. de Guatemala',
            'latitud' => 14.618594870641523,
            'longitud' => -90.53836429977162,
        ]);

        // Sucursal 3
        Branch::create([
            'nombre' => 'Colonia Mariscal, zona 11, Guatemala',
            'direccion' => '22 Calle 13-31, Cdad. de Guatemala',
            'latitud' => 14.606428644620845,
            'longitud' => -90.5506440268919,
        ]);
    }
}
