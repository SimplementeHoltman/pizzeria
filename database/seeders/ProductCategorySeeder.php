<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear la categoría "Pizzas"
        $pizzaCategory = Category::create([
            'nombre' => 'Pizzas',
            'descripcion' => 'Variedad de pizzas deliciosas.',
        ]);

        // Insertar 5 productos de pizzas asociados a la categoría
        Product::create([
            'nombre' => 'Pizza Margarita',
            'descripcion' => 'Pizza clásica con salsa de tomate, mozzarella y albahaca.',
            'precio' => 85.00,
            'stock' => 20,
            'imagen' => 'pizza-margarita.jpg',  // Nombre de la imagen
            'categoria_id' => $pizzaCategory->id,
        ]);

        Product::create([
            'nombre' => 'Pizza Pepperoni',
            'descripcion' => 'Pizza con abundante pepperoni y queso.',
            'precio' => 90.00,
            'stock' => 25,
            'imagen' => 'pizza-pepperoni.jpg',  // Nombre de la imagen
            'categoria_id' => $pizzaCategory->id,
        ]);

        Product::create([
            'nombre' => 'Pizza Hawaiana',
            'descripcion' => 'Pizza con piña, jamón y queso.',
            'precio' => 95.00,
            'stock' => 15,
            'imagen' => 'pizza-hawaiana.jpg',  // Nombre de la imagen
            'categoria_id' => $pizzaCategory->id,
        ]);

        Product::create([
            'nombre' => 'Pizza BBQ Chicken',
            'descripcion' => 'Pizza con pollo asado, salsa BBQ y cebolla.',
            'precio' => 100.00,
            'stock' => 10,
            'imagen' => 'pizza-bbq-chicken.jpg',  // Nombre de la imagen
            'categoria_id' => $pizzaCategory->id,
        ]);

        Product::create([
            'nombre' => 'Pizza Cuatro Quesos',
            'descripcion' => 'Pizza con una mezcla de mozzarella, parmesano, gorgonzola y ricotta.',
            'precio' => 110.00,
            'stock' => 12,
            'imagen' => 'pizza-cuatro-quesos.jpg',  // Nombre de la imagen
            'categoria_id' => $pizzaCategory->id,
        ]);

        // Crear la categoría "Calzones"
        $calzoneCategory = Category::create([
            'nombre' => 'Calzones',
            'descripcion' => 'Deliciosos calzones rellenos.',
        ]);

        // Insertar 3 productos de calzones asociados a la categoría
        Product::create([
            'nombre' => 'Calzone Supremo',
            'descripcion' => 'Calzone relleno con una mezcla de carnes y quesos.',
            'precio' => 70.00,
            'stock' => 18,
            'imagen' => 'calzone-supremo.jpg',  // Nombre de la imagen
            'categoria_id' => $calzoneCategory->id,
        ]);

        Product::create([
            'nombre' => 'Calzone Vegetariano',
            'descripcion' => 'Calzone relleno de vegetales frescos.',
            'precio' => 65.00,
            'stock' => 22,
            'imagen' => 'calzone-vegetariano.jpg',  // Nombre de la imagen
            'categoria_id' => $calzoneCategory->id,
        ]);

        Product::create([
            'nombre' => 'Meat Lovers Calzone',
            'descripcion' => 'Calzone con una variedad de carnes.',
            'precio' => 75.00,
            'stock' => 15,
            'imagen' => 'calzone-meat-lovers.jpg',  // Nombre de la imagen
            'categoria_id' => $calzoneCategory->id,
        ]);
    }
}
