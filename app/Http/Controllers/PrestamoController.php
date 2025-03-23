<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    public function index(Request $request){
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

    }
}
