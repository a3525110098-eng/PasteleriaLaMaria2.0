@extends('layouts.app')

@section('title', 'Roles | La María')
@section('header', 'Roles')

@section('content')
    <h2 class="page-heading">Roles del sistema</h2>
    <p class="page-description">Consulta los roles disponibles y las personas que los tienen asignados.</p>

    <section class="page-card">
        <h3>Roles registrados</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rol</th>
                        <th>Descripción</th>
                        <th>Usuarios asignados</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr>
                            <td>{{ $rol->id_rol }}</td>
                            <td>{{ $rol->nombre }}</td>
                            <td>{{ $rol->descripcion ?: 'Sin descripción' }}</td>
                            <td>{{ $rol->usuarios_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="page-card">
        <h3>Relación entre usuarios y roles</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @php $hayAsignaciones = false; @endphp
                    @foreach ($roles as $rol)
                        @foreach ($rol->usuarios as $usuario)
                            @php $hayAsignaciones = true; @endphp
                            <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $rol->nombre }}</td>
                                <td>
                                    <span class="status-badge {{ $usuario->activo ? 'status-badge--active' : 'status-badge--inactive' }}">
                                        {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    @unless ($hayAsignaciones)
                        <tr><td colspan="4">Todavía no hay usuarios con rol asignado.</td></tr>
                    @endunless
                </tbody>
            </table>
        </div>
    </section>
@endsection
