<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index() {
        // Obtener todos los reportes de la base de datos
        $reportes = DB::table('reportes')->orderBy('fecha', 'DESC')->get();

        return view('reporte.index', compact('reportes'));
    }
}
