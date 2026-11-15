<?php

namespace App\Http\Controllers;

use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('usuarios')
            ->withCount('usuarios')
            ->orderBy('id_rol')
            ->get();

        return view('roles', compact('roles'));
    }
}
