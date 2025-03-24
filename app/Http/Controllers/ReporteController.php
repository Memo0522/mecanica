<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteController extends Controller
{
    public function index()
    {
        // Obtener todos los reportes de la base de datos
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
                    return redirect()->back()->with('error', 'No hay datos para generar el reporte de adeudos.');
                }

                if ($formato === 'pdf') {
                    return $this->generarReportePDF($fechaInicio, $fechaFinal, $resultados, 'adeudos');
                } elseif ($formato === 'excel') {
                    return $this->generarReporteExcel($resultados, 'adeudos');
                }
            } else {
                $resultados = $this->obtenerInventario($fechaInicio, $fechaFinal, $opcionInventario);

                if (empty($resultados)) {
                    return redirect()->back()->with('error', 'No hay datos para generar el reporte de inventario.');
                }

                if ($formato === 'pdf') {
                    return $this->generarReportePDF($fechaInicio, $fechaFinal, $resultados, 'inventario');
                } elseif ($formato === 'excel') {
                    return $this->generarReporteExcel($resultados, 'inventario');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error en el servidor: ' . $e->getMessage());
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
                detalle_adeudo.nombre,
                GROUP_CONCAT(CONCAT(detalle_adeudo.descripcion, " $", detalle_adeudo.monto) SEPARATOR "\n") AS detalle
            ')
            ->groupBy('adeudos.id_adeudos')
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
        // Crear la carpeta si no existe
        $pdfFolder = storage_path('app/public/pdf');
        if (!file_exists($pdfFolder)) {
            mkdir($pdfFolder, 0777, true);
        }

        $dompdf = new Dompdf();
        $html = view('reporte.pdf', compact('fechaInicio', 'fechaFinal', 'datos', 'tipo'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfFileName = 'reporte_' . $tipo . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        $pdfPath = storage_path('app/public/pdf/' . $pdfFileName);
        file_put_contents($pdfPath, $dompdf->output());

        // Guardar en la base de datos
        DB::table('reportes')->insert([
            'fecha' => now()->format('Y-m-d'),
            'archivo' => $pdfFileName
        ]);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    private function generarReporteExcel($datos, $tipo)
    {
        // Crear la carpeta si no existe
        $excelFolder = storage_path('app/public/excel');
        if (!file_exists($excelFolder)) {
            mkdir($excelFolder, 0777, true);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de ' . ucfirst($tipo));

        // Configurar encabezados y datos según el tipo de reporte
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

        // Guardar el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $excelFileName = 'reporte_' . $tipo . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $excelPath = storage_path('app/public/excel/' . $excelFileName);
        $writer->save($excelPath);

        // Guardar en la base de datos
        DB::table('reportes')->insert(values: [
            'fecha' => now()->format('Y-m-d'),
            'archivo' => $excelFileName,
        ]);

        return response()->download($excelPath)->deleteFileAfterSend(true);
    }
}