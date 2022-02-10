<?php

namespace App\Http\Controllers;

use App\libros;
use Response;
use DB;
use Datatables;
use Illuminate\Http\Request;

class LibrosController extends Controller
{
    public function index()
    {
        return view('admin.libros');
    }

    public function show()
    {
        $libros = DB::table('libros')->get();

        return Datatables($libros)->toJson();
    }

    public function store(Request $request)
    {
		$libros = new libros();
        $libros->titulo = $request['titulo'];
        $libros->autor = $request['autor'];
        $libros->isbn = $request['isbn'];
        $libros->categoria = $request['categoria'];
        $libros->cantidad = $request['cantidad'];
        $libros->fecha_publicacion = $request['fecha_publicacion'];
        $libros->save();
        
        return 'Registro almacenado correctamente' ;
    }

    public function update(Request $request, $id)
    {
		$libros = libros::findOrFail($id);
        $libros->titulo = $request['titulo'];
        $libros->autor = $request['autor'];
        $libros->isbn = $request['isbn'];
        $libros->categoria = $request['categoria'];
        $libros->cantidad = $request['cantidad'];
        $libros->fecha_publicacion = $request['fecha_publicacion'];
        $libros->save();
        
        return 'Registro modificado correctamente' ;
    }

    public function destroy(Request $request, $id)
    {
		$libros = libros::findOrFail($id);
        $libros->delete();
        
        return 'Registro eliminado correctamente' ;
    }

    public function listLibros(Request $request)
    { 
        $libros = libros::where('titulo', 'LIKE', '%'.$request->busqueda.'%')->get();

        if(count($libros) == 0){
            $libros = libros::where('autor', 'LIKE', '%'.$request->busqueda.'%')->get();

            if(count($libros) == 0){
                $libros = libros::where('categoria', 'LIKE', '%'.$request->busqueda.'%')->get();

                if(count($libros) == 0){
                    $libros = libros::where('isbn', 'LIKE', '%'.$request->busqueda.'%')->get();
                }                
            }
        }

        $response = array();
        foreach($libros as $id){
            $response[] = array(
                "id"=>$id->id,
                "text"=>$id->titulo.' - '.$id->autor.' - '.$id->categoria,
            );
        }        

        return response()->json($response);
    }    
}
