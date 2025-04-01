<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $prestamos = DB::table('prestamos')
            ->when($search, function ($query, $search) {
                return $query->where('id_prestamos', 'like', "%{$search}%")
                    ->orWhere('matricula', 'like', "%{$search}%");
            })
            ->get();

        return view('prestamo.index', compact('prestamos'));
    }

    public function create()
    {
        return view('prestamo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required',
            'fecha' => 'required|date',
            'codigo' => 'required|array',
            'cantidad' => 'required|array',
            'descripcion' => 'required|array',
            'nombre' => 'required',
            'pe' => 'required',
            'grado' => 'required',
            'grupo' => 'required',
        ]);

        $matricula = $request->matricula;
        $fecha = $request->fecha;
        $codigo = $request->codigo;
        $cantidad = $request->cantidad;
        $descripcion = $request->descripcion;
        $nombre = $request->nombre;
        $pe = $request->pe;
        $grado = $request->grado;
        $grupo = $request->grupo;

        $pdf_nombre = "prestamo_" . $matricula . "_" . date("YmdHis") . ".pdf";

        try {
            DB::beginTransaction();

            $id_prestamos = DB::table('prestamos')->insertGetId([
                'matricula' => $matricula,
                'fecha' => $fecha,
                'pdf_nombre' => $pdf_nombre
            ]);

            foreach ($codigo as $i => $cod) {
                $inventario = DB::table('inventario')->where('codigo', $cod)->first();

                if (!$inventario || $inventario->cantidad < $cantidad[$i]) {
                    throw new \Exception("La cantidad solicitada del código {$cod} excede la cantidad disponible, no se puede realizar el préstamo.");
                }

                DB::table('detalle_prestamo')->insert([
                    'id_prestamos' => $id_prestamos,
                    'nombre' => $nombre,
                    'pe' => $pe,
                    'grado' => $grado,
                    'grupo' => $grupo,
                    'codigo' => $cod,
                    'cantidad' => $cantidad[$i],
                    'descripcion' => $descripcion[$i]
                ]);

                DB::table('inventario')->where('codigo', $cod)->decrement('cantidad', $cantidad[$i]);
            }

            DB::commit();

            // Generar el PDF
            $this->generarPDF($matricula, $fecha, $codigo, $cantidad, $descripcion, $pdf_nombre, $nombre, $pe, $grado, $grupo);

            return redirect()->route('prestamos.index')->with('message', 'Préstamo registrado correctamente. El PDF se generó en /pdf/' . $pdf_nombre);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('prestamos.index')->with('message', $e->getMessage());
        }
    }

    public function generarPDF($matricula, $fecha, $codigo, $cantidad, $descripcion, $pdf_nombre, $nombre, $pe, $grado, $grupo)
    {
        $fecha_formato = date("d \d\\e F \d\\e\l Y", strtotime($fecha));

        $html = view('pdf.plantilla_prestamo', compact(
            'matricula',
            'fecha_formato',
            'codigo',
            'cantidad',
            'descripcion',
            'nombre',
            'pe',
            'grado',
            'grupo'
        ))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Guardar el PDF
        file_put_contents(public_path("pdf/{$pdf_nombre}"), $dompdf->output());
    }

    public function verPDF($nombre_pdf)
    {
        $ruta_pdf = public_path("pdf/{$nombre_pdf}");

        if (file_exists($ruta_pdf)) {
            return response()->file($ruta_pdf);
        } else {
            return redirect()->back()->with('error', 'El archivo PDF no existe.');
        }
    }
    public function destroy($id)
{
    // Buscar el préstamo por ID
    $prestamo = DB::table('prestamos')->where('id_prestamos', $id)->first();

    // Verificar si el préstamo existe y si su estado no es "sin entregar"
    if ($prestamo && $prestamo->status !== 'SIN ENTREGAR') {
        // Eliminar el préstamo
        DB::table('prestamos')->where('id_prestamos', $id)->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('prestamos.index')->with('success', 'Préstamo eliminado correctamente.');
    } else {
        // Redirigir con mensaje de error
        return redirect()->route('prestamos.index')->with('error', 'No se puede eliminar el préstamo porque su estado es "sin entregar".');
    }
}
}

