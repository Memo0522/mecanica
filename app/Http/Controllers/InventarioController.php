<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
     public function index(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('inventario');

        if ($search) {
            $query->where('codigo', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
        }

        $inventario = $query->get();

        return view('inventario.index', compact('inventario'));
    }
}
