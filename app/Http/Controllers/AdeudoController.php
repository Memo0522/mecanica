<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdeudoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $adeudos = DB::table('adeudos')
            ->when($search, function ($query, $search) {
                return $query->where('id_adeudos', 'like', "%{$search}%")
                    ->orWhere('matricula', 'like', "%{$search}%");
            })
            ->orderBy('fecha', 'desc')
            ->get();

        return view('adeudo.index', compact('adeudos', 'search'));
    }

    public function create() {
        return view('adeudo.create');
    }
    public function store(Request $request)
    {

        $matricula = $request->input('matricula');
        $fecha = $request->input('fecha');
        $nombre = $request->input('nombre');
        $grado = $request->input('grado');
        $grupo = $request->input('grupo');
        $pe = $request->input('pe');
        $descripcion = $request->input('descripcion');
        $cantidad = $request->input('cantidad');
        $monto = $request->input('monto');

        // Calcular el total sumando cada cantidad * monto
        $total = 0;
        for ($i = 0; $i < count($cantidad); $i++) {
            $total += $cantidad[$i] * $monto[$i];
        }

        DB::beginTransaction();

        try {
            // Insertar el adeudo
            $id_adeudos = DB::table('adeudos')->insertGetId([
                'matricula' => $matricula,
                'fecha' => $fecha,
                'monto' => $total
            ]);

            // Insertar cada detalle
            for ($i = 0; $i < count($descripcion); $i++) {
                DB::table('detalle_adeudo')->insert([
                    'id_adeudos' => $id_adeudos,
                    'nombre' => $nombre,
                    'grado' => $grado,
                    'grupo' => $grupo,
                    'pe' => $pe,
                    'descripcion' => $descripcion[$i],
                    'cantidad' => $cantidad[$i],
                    'monto' => $monto[$i]
                ]);
            }

            DB::commit();

            return redirect()->route('adeudos.index')->with('success', 'Adeudo agregado exitosamente.')
;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un error al guardar el adeudo: ' . $e->getMessage());
        }
    }
}
