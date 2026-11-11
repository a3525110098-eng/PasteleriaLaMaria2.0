<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador', 'descripcion' => 'Gestiona usuarios, roles, productos, categorías y datos de la empresa.'],
            ['nombre' => 'Empleado', 'descripcion' => 'Administra productos y categorías, según los permisos definidos.'],
            ['nombre' => 'Cliente', 'descripcion' => 'Representa al comprador de la tienda pública; no obtiene acceso administrativo.'],
        ];

        foreach ($roles as $rol) {
            Role::updateOrCreate(['nombre' => $rol['nombre']], ['descripcion' => $rol['descripcion']]);
        }

        // El administrador que ya existe (admin@correo.com)
        $admin = User::where('email', 'admin@correo.com')->first();
        if ($admin) {
            $admin->roles()->syncWithoutDetaching([
                Role::where('nombre', 'Administrador')->value('id_rol'),
            ]);
        }

        // Un empleado de prueba para las pruebas funcionales
        $empleado = User::firstOrCreate(
            ['email' => 'empleado@correo.com'],
            ['name' => 'Empleado Demo', 'password' => Hash::make('123'), 'activo' => true]
        );
        $empleado->roles()->syncWithoutDetaching([
            Role::where('nombre', 'Empleado')->value('id_rol'),
        ]);
    }
}
