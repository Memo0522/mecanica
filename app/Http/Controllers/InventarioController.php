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

    public function create(){

        return view('inventario.create');
    }

    public function store(Request $request){
        //$request->validate([])

        DB::table('inventario')->insert([
            "codigo"=>$request->codigo, 
            "descripcion"=>$request->descripcion,
            "cantidad"=>$request->cantidad, 
            "categoria"=>$request->categoria,
            "medidas"=>$request->medidas, 
            "ubicacion"=>$request->ubicacion, 
            "tipo_inventario"=>$request->tipo_inventario
        ]);
        return redirect()->route('inventario.index');
    }

    public function edit($inventario){
        $data = DB::table('inventario')
            ->where('codigo', '=', $inventario)       
            ->first();
        return view('inventario.edit', compact('data'));
    }

    public function update(Request $request, $codigo){
        DB::table('inventario')
            ->where('codigo', '=', $codigo)
            ->update(
                [
                    "codigo"=>$request->codigo, 
                    "descripcion"=>$request->descripcion,
                    "cantidad"=>$request->cantidad, 
                    "categoria"=>$request->categoria,
                    "medidas"=>$request->medidas, 
                    "ubicacion"=>$request->ubicacion, 
                    "tipo_inventario"=>$request->tipo_inventario
                ]
            );
        return redirect()->route('inventario.index');
    }
    public function destroy($codigo){
        $data = DB::table('inventario')
            ->where('codigo', '=', $codigo)       
            ->delete();
        return redirect()->route('inventario.index');
    }
}
