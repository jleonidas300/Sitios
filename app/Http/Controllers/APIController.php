<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Establecimiento;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //metodo para cargar todas las categorias
    
    public function categorias()
    {
        $categorias = Categoria::all();

        return response()->json($categorias);
    }

    //muestra los establecimientos de la categoria
    public function categoria(Categoria $categoria)
    {
    //dd($categoria);
    //return response()->json($categoria);
        $establecimientos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->take(3)->get();
        return response()->json($establecimientos);
    }
}
