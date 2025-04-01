<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;


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

    public function create()
    {

        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        //$request->validate([])

        DB::table('alumnos')->insert([

            "matricula" => $request->matricula,
            "nombre" => $request->nombre,
            "pe" => $request->pe,
            "grado" => $request->grado,
            "grupo" => $request->grupo,

        ]);
        return redirect()->route('alumnos.index');
    }

    public function edit($matricula)
    {
        $data = DB::table('alumnos')
            ->where('matricula', '=', $matricula)
            ->first();
        return view('alumnos.edit', compact('data'));
    }

    public function update(Request $request, $matricula)
    {
        DB::table('alumnos')
            ->where('matricula', '=', $matricula)
            ->update(
                [
                    "matricula" => $request->matricula,
                    "nombre" => $request->nombre,
                    "pe" => $request->pe,
                    "grado" => $request->grado,
                    "grupo" => $request->grupo,
                ]
            );
        return redirect()->route('alumnos.index');
    }

    public function destroy($matricula)
    {

        // Verificar si el alumno tiene préstamos
        $tienePrestamos = DB::table('prestamos')
            ->where('matricula', $matricula)
            ->exists(); // Devuelve true si hay registros, false si no hay

        if ($tienePrestamos) {
            return redirect()->route('alumnos.index')->with('message', 'No se puede eliminar el alumno porque tiene préstamos activos.');
        }

        // Si no tiene préstamos, eliminar el alumno
        DB::table('alumnos')
            ->where('matricula', $matricula)
            ->delete();

        return redirect()->route('alumnos.index')->with('message', 'Alumno eliminado correctamente.');
    }


    public function importarAlumnos(Request $request)
    {
        if ($request->hasFile('dataCliente')) {
            $file = $request->file('dataCliente');
            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, ['xlsx', 'csv'])) {
                try {
                    $spreadsheet = IOFactory::load($file->getRealPath());
                    $hoja = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                    foreach ($hoja as $index => $row) {
                        if ($index === 1) continue; // Saltar encabezado

                        // Validar que no estén vacíos
                        if (empty($row['A'])) continue;

                        // Verificar si ya existe
                        $existe = DB::table('alumnos')->where('matricula', $row['A'])->first();

                        if ($existe) {
                            // Actualizar si ya existe
                            DB::table('alumnos')->where('matricula', $row['A'])->update([
                                'nombre' => $row['B'],
                                'pe' => $row['C'],
                                'grado' => $row['D'],
                                'grupo' => $row['E'],
                            ]);
                        } else {
                            // Insertar si no existe
                            DB::table('alumnos')->insert([
                                'matricula' => $row['A'],
                                'nombre' => $row['B'],
                                'pe' => $row['C'],
                                'grado' => $row['D'],
                                'grupo' => $row['E'],
                            ]);
                        }
                    }

                    return redirect()->back()->with('success', 'Los alumnos se importaron correctamente.');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'El archivo debe ser .xlsx o .csv.');
            }
        } else {
            return redirect()->back()->with('error', 'No se ha subido ningún archivo.');
        }
    }
}
