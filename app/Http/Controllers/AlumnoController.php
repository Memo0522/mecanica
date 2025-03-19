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

    public function create(){

        return view('alumnos.create');
    }

    public function store(Request $request){
        //$request->validate([])

        DB::table('alumnos')->insert([

            "matricula"=>$request->matricula,
            "nombre"=>$request->nombre,
            "pe"=>$request->pe,
            "grado"=>$request->grado, 
            "grupo"=>$request->grupo,

        ]);
        return redirect()->route('alumnos.index');
    }

    public function edit($matricula){
        $data = DB::table('alumnos')
            ->where('matricula', '=', $matricula)       
            ->first();
        return view('alumnos.edit', compact('data'));
    }

    public function update(Request $request, $matricula){
        DB::table('alumnos')
            ->where('matricula', '=', $matricula)
            ->update(
                [
                    "matricula"=>$request->matricula,
                    "nombre"=>$request->nombre,
                    "pe"=>$request->pe,
                    "grado"=>$request->grado, 
                    "grupo"=>$request->grupo,
                ]
            );
        return redirect()->route('alumnos.index');
    }
    
    public function destroy($matricula){
        $data = DB::table('alumnos')
            ->where('matricula', '=', $matricula)       
            ->delete();
        return redirect()->route('alumnos.index');
    }
}
