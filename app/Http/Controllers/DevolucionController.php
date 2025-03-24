<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DevolucionController extends Controller
{
    public function index(Request $request)
    {
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

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id_prestamos' => 'required|integer',
            'status' => 'required|in:SIN ENTREGAR,ENTREGADO',
        ]);

        $id_prestamos = $request->input('id_prestamos');
        $status = $request->input('status');

        try {
            DB::beginTransaction();

            // Actualizar el estado del préstamo
            DB::table('prestamos')
                ->where('id_prestamos', $id_prestamos)
                ->update(['status' => $status]);

            // Si el estado es "ENTREGADO", devolver los artículos al inventario
            if ($status === 'ENTREGADO') {
                $detalles = DB::table('detalle_prestamo')
                    ->where('id_prestamos', $id_prestamos)
                    ->get();

                foreach ($detalles as $detalle) {
                    DB::table('inventario')
                        ->where('codigo', $detalle->codigo)
                        ->increment('cantidad', $detalle->cantidad);
                }
            }

            DB::commit();

            return redirect()->route('devoluciones.index')
                ->with('success', 'Estado del préstamo actualizado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('devoluciones.index')
                ->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }
}