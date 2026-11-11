<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;

class ProductoApiController extends Controller
{
    /**
     * Consultar productos activos y sus imágenes.
     */
    public function index(): JsonResponse
    {
        $productos = Producto::with('categoria')
            ->where('activa', true)
            ->whereHas('categoria', function ($query) {
                $query->where('activa', true);
            })
            ->orderBy('nombre')
            ->get();

        $datos = $productos->map(function ($producto) {
            return [
                'id_producto' => $producto->id_producto,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio' => $producto->precio,
                'categoria' => $producto->categoria->nombre,
                'imagen' => $producto->image_url
                    ? asset('storage/' . $producto->image_url)
                    : null,
            ];
        });

        return response()->json([
            'success' => true,
            'total' => $datos->count(),
            'data' => $datos,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
