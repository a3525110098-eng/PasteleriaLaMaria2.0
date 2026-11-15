@extends('layouts.app')

@section('title', 'Empresa | La María')
@section('header', 'Empresa')

@section('content')
    <h2 class="page-heading">Datos de la empresa</h2>
    <p class="page-description">Consulta y actualiza la información general de Pastelería La María.</p>

    @if (session('success'))
        <div class="alert alert--success" role="status">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert--error" role="alert">{{ session('error') }}</div>
    @endif

    <section class="page-card">
        <h3>{{ $empresa->exists ? 'Información registrada' : 'Registrar información de la empresa' }}</h3>

        <form action="{{ route('empresa.update') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre_comercial" class="form-label">Nombre comercial *</label>
                <input type="text" id="nombre_comercial" name="nombre_comercial" class="form-control"
                       maxlength="100" value="{{ old('nombre_comercial', $empresa->nombre_comercial) }}" required>
                @error('nombre_comercial') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="razon_social" class="form-label">Razón social</label>
                <input type="text" id="razon_social" name="razon_social" class="form-control"
                       maxlength="150" value="{{ old('razon_social', $empresa->razon_social) }}">
                @error('razon_social') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="rfc" class="form-label">RFC</label>
                <input type="text" id="rfc" name="rfc" class="form-control"
                       maxlength="13" value="{{ old('rfc', $empresa->rfc) }}">
                @error('rfc') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-control"
                       maxlength="20" value="{{ old('telefono', $empresa->telefono) }}">
                @error('telefono') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="numero_whatsapp" class="form-label">Número de WhatsApp *</label>
                <input type="text" id="numero_whatsapp" name="numero_whatsapp" class="form-control"
                       maxlength="20" value="{{ old('numero_whatsapp', $empresa->numero_whatsapp) }}" required>
                @error('numero_whatsapp') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo electrónico *</label>
                <input type="email" id="email" name="email" class="form-control"
                       maxlength="100" value="{{ old('email', $empresa->email) }}" required>
                @error('email') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="ubicacion" class="form-label">Ubicación *</label>
                <input type="text" id="ubicacion" name="ubicacion" class="form-control"
                       maxlength="255" value="{{ old('ubicacion', $empresa->ubicacion) }}" required>
                @error('ubicacion') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="horario_normal" class="form-label">Horario normal *</label>
                <input type="text" id="horario_normal" name="horario_normal" class="form-control"
                       maxlength="255" value="{{ old('horario_normal', $empresa->horario_normal) }}" required>
                @error('horario_normal') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="horario_especial" class="form-label">Horario especial</label>
                <input type="text" id="horario_especial" name="horario_especial" class="form-control"
                       maxlength="255" value="{{ old('horario_especial', $empresa->horario_especial) }}">
                @error('horario_especial') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control form-control--textarea"
                          rows="3" maxlength="2000">{{ old('descripcion', $empresa->descripcion) }}</textarea>
                @error('descripcion') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="sitio_web" class="form-label">Sitio web</label>
                <input type="text" id="sitio_web" name="sitio_web" class="form-control"
                       maxlength="255" value="{{ old('sitio_web', $empresa->sitio_web) }}">
                @error('sitio_web') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="logotipo" class="form-label">Logotipo (JPG, PNG o WEBP, máx. 2 MB)</label>
                @if ($empresa->logotipo)
                    <div>
                        <img src="{{ asset('storage/' . $empresa->logotipo) }}" alt="Logotipo actual"
                             style="max-width: 140px; border-radius: 8px; margin-bottom: 8px;">
                    </div>
                @endif
                <input type="file" id="logotipo" name="logotipo" class="form-control"
                       accept="image/png,image/jpeg,image/webp">
                @error('logotipo') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn--primary">Guardar datos</button>
            </div>
        </form>
    </section>
@endsection
