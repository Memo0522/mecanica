<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class FilterController extends Controller
{
    public function buscarAlumno(Request $request) {
        $matricula = $request->get('matricula');
        $alumno = DB::table('alumnos')->where('matricula', $matricula)->first();
        return response()->json($alumno ?? []);
    }
    
    public function buscarDescripcion(Request $request) {
        $descripcion = $request->get('descripcion');
        $items = DB::table('inventario')
            ->where('descripcion', 'like', "%$descripcion%")
            ->get(['codigo', 'descripcion']);
        return response()->json($items);
    }
    
}
