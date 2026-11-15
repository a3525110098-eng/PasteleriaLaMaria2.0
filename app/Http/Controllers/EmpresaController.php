<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function edit()
    {
        $empresa = Empresa::first() ?? new Empresa();

        return view('empresa', compact('empresa'));
    }

    public function update(Request $request): RedirectResponse
    {
        $soloTelefono = 'regex:/^[0-9+\-\s()]+$/';

        $datos = $request->validate([
            'nombre_comercial' => ['required', 'string', 'max:100'],
            'razon_social' => ['nullable', 'string', 'max:150'],
            'rfc' => ['nullable', 'string', 'regex:/^[A-Za-zÑñ&0-9]{12,13}$/'],
            'telefono' => ['nullable', 'max:20', $soloTelefono],
            'numero_whatsapp' => ['required', 'max:20', $soloTelefono],
            'email' => ['required', 'email', 'max:100'],
            'ubicacion' => ['required', 'string', 'max:255'],
            'horario_normal' => ['required', 'string', 'max:255'],
            'horario_especial' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
            'logotipo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'max' => 'El campo :attribute es demasiado largo.',
            'email' => 'Escribe un correo electrónico válido.',
            'url' => 'Escribe una dirección web válida, por ejemplo https://ejemplo.com',
            'rfc.regex' => 'El RFC debe tener 12 o 13 caracteres alfanuméricos.',
            'telefono.regex' => 'El teléfono solo puede incluir números, espacios y los signos + - ( ).',
            'numero_whatsapp.regex' => 'El número de WhatsApp solo puede incluir números, espacios y los signos + - ( ).',
            'logotipo.image' => 'El logotipo debe ser una imagen.',
            'logotipo.mimes' => 'El logotipo debe ser JPG, PNG o WEBP.',
            'logotipo.max' => 'El logotipo no debe pesar más de 2 MB.',
        ], [
            'nombre_comercial' => 'nombre comercial',
            'razon_social' => 'razón social',
            'numero_whatsapp' => 'número de WhatsApp',
            'email' => 'correo',
            'ubicacion' => 'ubicación',
            'horario_normal' => 'horario normal',
            'horario_especial' => 'horario especial',
            'descripcion' => 'descripción',
            'sitio_web' => 'sitio web',
        ]);

        if (!empty($datos['rfc'])) {
            $datos['rfc'] = strtoupper($datos['rfc']);
        }

        $empresa = Empresa::first();

        if ($request->hasFile('logotipo')) {
            if ($empresa && $empresa->logotipo) {
                Storage::disk('public')->delete($empresa->logotipo);
            }
            $datos['logotipo'] = $request->file('logotipo')->store('empresa', 'public');
        } else {
            unset($datos['logotipo']);
        }

        if ($empresa) {
            $empresa->update($datos);
        } else {
            Empresa::create($datos);
        }

        return redirect()->route('empresa')
            ->with('success', 'Los datos de la empresa se guardaron correctamente.');
    }
}
