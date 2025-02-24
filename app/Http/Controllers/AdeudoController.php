<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
