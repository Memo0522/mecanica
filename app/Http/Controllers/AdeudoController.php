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

    public function create()
    {
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

            return redirect()->route('adeudos.index')->with('success', 'Adeudo agregado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un error al guardar el adeudo: ' . $e->getMessage());
        }
    }

    public function detalles($id)
    {
        $detalles = DB::table('detalle_adeudo')
            ->where('id_adeudos', $id)
            ->get();

        if ($detalles->isEmpty()) {
            return "<p>No se encontraron detalles para este adeudo.</p>";
        }

        $html = "<h3>Detalles del Adeudo</h3>";
        $html .= "<table border='1' cellpadding='10' cellspacing='0'>";
        $html .= "<thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cuatrimestre</th>
                    <th>Grupo</th>
                    <th>PE</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Monto</th>
                </tr>
              </thead>";
        $html .= "<tbody>";

        foreach ($detalles as $row) {
            $html .= "<tr>";
            $html .= "<td>" . e($row->nombre) . "</td>";
            $html .= "<td>" . e($row->grado) . "</td>";
            $html .= "<td>" . e($row->grupo) . "</td>";
            $html .= "<td>" . e($row->pe) . "</td>";
            $html .= "<td>" . e($row->descripcion) . "</td>";
            $html .= "<td>" . e($row->cantidad) . "</td>";
            $html .= "<td>$" . number_format($row->monto, 2) . "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody></table>";

        return $html;
    }

    public function update(Request $request, $id)
    {
        $estatus = $request->input('estatus');

        DB::table('adeudos')
            ->where('id_adeudos', $id)
            ->update(['estatus' => $estatus]);

        return redirect()->route('adeudos.index');
    }

    public function destroy($id)
    {
        DB::table('detalle_adeudo')->where('id_adeudos', "=", $id)->delete();
        DB::table('adeudos')->where('id_adeudos', "=", $id)->delete();

        return redirect()->route('adeudos.index')->with('success', 'Adeudo eliminado correctamente.');
    }
}
