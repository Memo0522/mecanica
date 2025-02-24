<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener la búsqueda si existe
        $search = $request->input('search');

        // Obtener alumnos con Query Builder
        $alumnos = DB::table('alumnos')
            ->when($search, function ($query, $search) {
                return $query->where('matricula', 'like', "%$search%");
            })
            ->get();

        return view('alumnos.index', compact('alumnos'));
    }
}
