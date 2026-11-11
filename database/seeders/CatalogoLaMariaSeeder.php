<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class CatalogoLaMariaSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['Pasteles', 'Pastel Chocolate María', 'Pastel de tres capas con betún de chocolate semiamargo.', 480, '06_pastel_de_chocolate.png'],
            ['Pasteles', 'Pastel Frutos Rojos', 'Pastel esponjoso con crema y fresas frescas.', 520, '11_pastel_de_fresas.png'],
            ['Pasteles', 'Pastel de Zanahoria', 'Pastel húmedo de zanahoria con betún de queso crema.', 430, '07_pastel_de_zanahoria.png'],
            ['Cupcakes', 'Cupcake Vainilla', 'Cupcake de vainilla con betún rosa y fresa.', 35, '10_cupcake_de_vainilla.png'],
            ['Cupcakes', 'Cupcake Red Velvet', 'Cupcake red velvet con betún de queso crema.', 38, '01_cupcake_red_velvet.png'],
            ['Galletas', 'Galletas de Mantequilla', 'Paquete de galletas artesanales de mantequilla.', 180, '02_galletas_de_mantequilla.png'],
            ['Galletas', 'Galletas Decoradas', 'Paquete de galletas con glaseado decoradas a mano.', 280, '03_galletas_decoradas.png'],
            ['Postres', 'Cheesecake de Fresa', 'Cheesecake cremoso con salsa y fresas frescas.', 450, '08_cheesecake_de_fresa.png'],
            ['Postres', 'Brownie con Nuez', 'Brownie de chocolate con nuez.', 45, '09_brownie_con_nuez.png'],
            ['Postres', 'Mini Postres para Eventos', 'Charola con 12 mini postres variados.', 350, '05_mini_postres_surtidos.png'],
            ['Especiales', 'Mesa de Postres', 'Mesa de postres personalizada para tu evento. Bajo cotización.', null, '04_mesa_de_postres.png'],
            ['Especiales', 'Paquete Celebración', 'Paquete para celebraciones. Bajo cotización.', null, '12_paquete_para_eventos.png'],
        ];

        foreach ($productos as [$categoria, $nombre, $descripcion, $precio, $imagen]) {
            $idCategoria = Categoria::where('nombre', $categoria)->value('id_categoria');

            if (! $idCategoria) {
                continue;
            }

            Producto::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'id_categoria' => $idCategoria,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'image_url' => 'productos/' . $imagen,
                    'activa' => true,
                ]
            );
        }
    }
}
