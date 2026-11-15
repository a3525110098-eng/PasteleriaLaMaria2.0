<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('usuarios', $this->datosVista());
    }

    public function edit(User $usuario)
    {
        return view('usuarios', $this->datosVista() + [
            'usuarioEditar' => $usuario->load('roles'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate($this->reglas(), $this->mensajes(), $this->atributos());

        DB::transaction(function () use ($datos) {
            $usuario = User::create([
                'name' => $datos['name'],
                'email' => $datos['email'],
                'password' => $datos['password'], // se cifra con hash automáticamente
                'activo' => true,
            ]);

            $usuario->roles()->sync([$datos['id_rol']]);
        });

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $datos = $request->validate($this->reglas($usuario), $this->mensajes(), $this->atributos());

        $idRolAdmin = Role::where('nombre', 'Administrador')->value('id_rol');

        if ($this->esUltimoAdministradorActivo($usuario) && (int) $datos['id_rol'] !== (int) $idRolAdmin) {
            return back()->withInput()
                ->with('error', 'No puedes quitar el rol Administrador a la única cuenta Administradora.');
        }

        DB::transaction(function () use ($datos, $usuario) {
            $usuario->name = $datos['name'];
            $usuario->email = $datos['email'];

            if (!empty($datos['password'])) {
                $usuario->password = $datos['password'];
            }

            $usuario->save();
            $usuario->roles()->sync([$datos['id_rol']]);
        });

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function cambiarEstado(User $usuario): RedirectResponse
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        if ($usuario->activo && $this->esUltimoAdministradorActivo($usuario)) {
            return back()->with('error', 'No se puede desactivar la única cuenta Administradora.');
        }

        $usuario->activo = !$usuario->activo;
        $usuario->save();

        return back()->with('success', $usuario->activo
            ? 'Cuenta activada correctamente.'
            : 'Cuenta desactivada correctamente.');
    }

    // ---------- Apoyo ----------

    private function datosVista(): array
    {
        return [
            'usuarios' => User::with('roles')->orderBy('name')->paginate(10),
            'roles' => $this->rolesAsignables(),
        ];
    }

    private function rolesAsignables()
    {
        return Role::whereIn('nombre', ['Administrador', 'Empleado'])
            ->orderBy('nombre')
            ->get();
    }

    private function esUltimoAdministradorActivo(User $usuario): bool
    {
        if (!$usuario->activo || !$usuario->esAdministrador()) {
            return false;
        }

        $total = User::where('activo', true)
            ->whereHas('roles', fn ($q) => $q->where('nombre', 'Administrador'))
            ->count();

        return $total <= 1;
    }

    private function reglas(?User $usuario = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($usuario?->id),
            ],
            'password' => [
                $usuario ? 'nullable' : 'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
            ],
            'id_rol' => [
                'required',
                Rule::in($this->rolesAsignables()->pluck('id_rol')->all()),
            ],
        ];
    }

    private function mensajes(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'Escribe un correo electrónico válido.',
            'unique' => 'Ya existe un usuario con ese :attribute.',
            'max' => 'El campo :attribute no debe superar :max caracteres.',
            'confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres, con letras y números.',
            'password.regex' => 'La contraseña debe tener mínimo 8 caracteres, con letras y números.',
            'id_rol.in' => 'Selecciona un rol válido.',
        ];
    }

    private function atributos(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo',
            'password' => 'contraseña',
            'id_rol' => 'rol',
        ];
    }
}
