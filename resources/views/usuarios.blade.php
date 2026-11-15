@extends('layouts.app')

@section('title', 'Usuarios | La María')
@section('header', 'Usuarios')

@section('content')
    @php
        $editando = isset($usuarioEditar);
        $rolActual = old('id_rol', $editando ? optional($usuarioEditar->roles->first())->id_rol : '');
    @endphp

    <h2 class="page-heading">Administración de usuarios</h2>
    <p class="page-description">Consulta y administra las personas que usarán el sistema.</p>

    @if (session('success'))
        <div class="alert alert--success" role="status">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert--error" role="alert">{{ session('error') }}</div>
    @endif

    <section class="page-card">
        <h3>{{ $editando ? 'Editar usuario' : 'Registrar usuario' }}</h3>

        <form action="{{ $editando ? route('usuarios.update', $usuarioEditar->id) : route('usuarios.store') }}"
              method="POST" class="form" autocomplete="off">
            @csrf
            @if ($editando) @method('PUT') @endif

            <div class="form-group">
                <label for="name" class="form-label">Nombre *</label>
                <input type="text" id="name" name="name" class="form-control"
                       maxlength="255" value="{{ old('name', $usuarioEditar->name ?? '') }}" required>
                @error('name') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo electrónico *</label>
                <input type="email" id="email" name="email" class="form-control"
                       maxlength="255" value="{{ old('email', $usuarioEditar->email ?? '') }}" required>
                @error('email') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="id_rol" class="form-label">Rol *</label>
                <select id="id_rol" name="id_rol" class="form-control" required>
                    <option value="">Selecciona un rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id_rol }}" {{ (string) $rolActual === (string) $rol->id_rol ? 'selected' : '' }}>
                            {{ $rol->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_rol') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    Contraseña {{ $editando ? '(déjala vacía para conservar la actual)' : '*' }}
                </label>
                <input type="password" id="password" name="password" class="form-control"
                       autocomplete="new-password" {{ $editando ? '' : 'required' }}>
                <small>Mínimo 8 caracteres, con letras y números.</small>
                @error('password') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmar contraseña {{ $editando ? '' : '*' }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                       autocomplete="new-password" {{ $editando ? '' : 'required' }}>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn--primary">
                    {{ $editando ? 'Guardar cambios' : 'Registrar usuario' }}
                </button>
                @if ($editando)
                    <a href="{{ route('usuarios.index') }}" class="btn btn--secondary">Cancelar edición</a>
                @else
                    <button type="reset" class="btn btn--secondary">Limpiar</button>
                @endif
            </div>
        </form>
    </section>

    <section class="page-card">
        <h3>Usuarios registrados</h3>

        @if ($usuarios->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->roles->pluck('nombre')->join(', ') ?: 'Sin rol' }}</td>
                                <td>
                                    <span class="status-badge {{ $usuario->activo ? 'status-badge--active' : 'status-badge--inactive' }}">
                                        {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn--secondary">Editar</a>
                                        <form action="{{ route('usuarios.estado', $usuario->id) }}" method="POST"
                                              onsubmit="return confirm('{{ $usuario->activo ? '¿Deseas desactivar esta cuenta?' : '¿Deseas activar esta cuenta?' }}');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn {{ $usuario->activo ? 'btn--danger' : 'btn--primary' }}">
                                                {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-container">{{ $usuarios->links() }}</div>
        @else
            <p>Todavía no hay usuarios registrados.</p>
        @endif
    </section>
@endsection
