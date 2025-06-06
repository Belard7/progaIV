<?php

namespace App\Http\Controllers;

use App\Models\LibrosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libros = DB::select("select * from tbl_libros");
        return view("index",compact("libros"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $titulo = $request->input("intitulo");
        $autor = $request->input("inautor");
        #$dispo = $request->input("checkdis");
        DB::insert("INSERT INTO tbl_libros(titulo,autor) 
                VALUES(?,?)",[$titulo,$autor]);
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LibrosModel $librosModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $libro = DB::select("SELECT * FROM tbl_libros WHERE id=?",
                            [$id])[0];
        return view("editar",compact("libro"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $titulo = $request->input("intitulo");
        $autor = $request->input("inautor");
        $disponible = $request->has("disponible") ? 1 : 0; // Cambiado de "disponibilidad" a "disponible"
    
        DB::update("UPDATE tbl_libros SET titulo=?, autor=?, disponibilidad=?
         WHERE id=?", [$titulo, $autor, $disponible, $id]);
        
        return redirect()->route("index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $libro = LibrosModel::findOrFail($id);
       $libro->delete();
       return redirect()->route('index');
    }
}
