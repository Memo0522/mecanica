<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    public function index(Request $request){

        $search = $request->input('search', '');

        // Consulta usando Query Builder
        $query = DB::table('prestamos');
        if ($search) {
            $query->where('id_prestamos', 'like', "%$search%")
                  ->orWhere('matricula', 'like', "%$search%");
        }
        $prestamos = $query->orderBy('fecha', 'desc')->get();

        return view('devoluciones.index', compact('prestamos', 'search'));

    }

    
    //
}
