<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteController extends Controller
{
    public function index()
    {
        $reportes = DB::table('reportes')->orderBy('fecha', 'DESC')->get();
        return view('reporte.index', compact('reportes'));
    }

    public function generarReporte(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date',
            'reporte_tipo' => 'required|in:adeudos,inventario',
            'formato' => 'required|in:pdf,excel',
            'opcion_inventario' => 'nullable|string',
        ]);

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFinal = $request->input('fecha_final');
        $reporteTipo = $request->input('reporte_tipo');
        $formato = $request->input('formato');
        $opcionInventario = $request->input('opcion_inventario');

        try {
            if ($reporteTipo === 'adeudos') {
                $resultados = $this->obtenerAdeudos($fechaInicio, $fechaFinal);

                if (empty($resultados)) {
                    return redirect()->route('reportes.index')->with('error', 'No hay datos para generar el reporte de adeudos.');
                }

                if ($formato === 'pdf') {
                    return $this->generarReportePDF($fechaInicio, $fechaFinal, $resultados, 'adeudos');
                } else {
                    return $this->generarReporteExcel($resultados, 'adeudos');
                }
            } else {
                $resultados = $this->obtenerInventario($fechaInicio, $fechaFinal, $opcionInventario);

                if (empty($resultados)) {
                    return redirect()->route('reportes.index')->with('error', 'No hay datos para generar el reporte de inventario.');
                }

                if ($formato === 'pdf') {
                    return $this->generarReportePDF($fechaInicio, $fechaFinal, $resultados, 'inventario');
                } else {
                    return $this->generarReporteExcel($resultados, 'inventario');
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('reportes.index')->with('error', 'Error en el servidor: ' . $e->getMessage());
        }
    }

    public function verReporte($archivo)
    {
        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
        $rutaBase = $extension === 'pdf' ? 'pdf/' : 'excel/';
        $rutaCompleta = storage_path('app/public/' . $rutaBase . $archivo);

        if (!file_exists($rutaCompleta)) {
            abort(404);
        }

        if ($extension === 'pdf') {
            return response()->file($rutaCompleta, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$archivo.'"'
            ]);
        } else {
            return response()->file($rutaCompleta, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'inline; filename="'.$archivo.'"'
            ]);
        }
    }

    private function obtenerAdeudos($fechaInicio, $fechaFinal)
    {
        return DB::table('adeudos')
            ->join('detalle_adeudo', 'detalle_adeudo.id_adeudos', '=', 'adeudos.id_adeudos')
            ->whereBetween('adeudos.fecha', [$fechaInicio, $fechaFinal])
            ->selectRaw('
                adeudos.id_adeudos,
                adeudos.matricula,
                adeudos.fecha,
                adeudos.monto AS monto_adeudo,
                MAX(detalle_adeudo.nombre) AS nombre,
                GROUP_CONCAT(CONCAT(detalle_adeudo.descripcion, " $", detalle_adeudo.monto) SEPARATOR "\n") AS detalle
            ')
            ->groupBy(
                'adeudos.id_adeudos',
                'adeudos.matricula',
                'adeudos.fecha',
                'adeudos.monto'
            )
            ->get()
            ->toArray();
    }

    private function obtenerInventario($fechaInicio, $fechaFinal, $tipoInventario)
    {
        $query = DB::table('inventario')
            ->whereBetween('fecha_actualizacion', [$fechaInicio, $fechaFinal]);

        if ($tipoInventario !== 'General') {
            $query->where('tipo_inventario', $tipoInventario);
        }

        return $query->get()->toArray();
    }

    private function generarReportePDF($fechaInicio, $fechaFinal, $datos, $tipo)
    {
        $dompdf = new Dompdf();
        $html = view('reporte.pdf', compact('fechaInicio', 'fechaFinal', 'datos', 'tipo'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nombreArchivo = 'reporte_' . $tipo . '_' . now()->format('Y-m-d_His') . '.pdf';
        $rutaRelativa = 'pdf/' . $nombreArchivo;
        $rutaCompleta = storage_path('app/public/' . $rutaRelativa);
        
        if (!file_exists(dirname($rutaCompleta))) {
            mkdir(dirname($rutaCompleta), 0755, true);
        }

        file_put_contents($rutaCompleta, $dompdf->output());

        DB::table('reportes')->insert([
            'fecha' => now()->format('Y-m-d'),
            'archivo' => $nombreArchivo
        ]);

        return response()->download($rutaCompleta)->deleteFileAfterSend(false);
    }

    private function generarReporteExcel($datos, $tipo)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de ' . ucfirst($tipo));

        if ($tipo === 'adeudos') {
            $sheet->fromArray([
                ['Matrícula', 'Nombre', 'Detalles', 'Fecha', 'Monto Adeudo'],
            ], null, 'A1');

            $row = 2;
            foreach ($datos as $registro) {
                $sheet->fromArray([
                    $registro->matricula,
                    $registro->nombre,
                    $registro->detalle,
                    $registro->fecha,
                    $registro->monto_adeudo,
                ], null, 'A' . $row);
                $row++;
            }
        } else {
            $sheet->fromArray([
                ['Código', 'Descripción', 'Cantidad', 'Categoría', 'Medidas', 'Ubicación', 'Tipo Inventario'],
            ], null, 'A1');

            $row = 2;
            foreach ($datos as $registro) {
                $sheet->fromArray([
                    $registro->codigo,
                    $registro->descripcion,
                    $registro->cantidad,
                    $registro->categoria,
                    $registro->medidas,
                    $registro->ubicacion,
                    $registro->tipo_inventario,
                ], null, 'A' . $row);
                $row++;
            }
        }

        $nombreArchivo = 'reporte_' . $tipo . '_' . now()->format('Y-m-d_His') . '.xlsx';
        $rutaRelativa = 'excel/' . $nombreArchivo;
        $rutaCompleta = storage_path('app/public/' . $rutaRelativa);
        
        if (!file_exists(dirname($rutaCompleta))) {
            mkdir(dirname($rutaCompleta), 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($rutaCompleta);

        DB::table('reportes')->insert([
            'fecha' => now()->format('Y-m-d'),
            'archivo' => $nombreArchivo
        ]);

        return response()->download($rutaCompleta)->deleteFileAfterSend(false);
    }
}