<?php

namespace App\Http\Controllers;

use App\prestamos;
use Response;
use DB;
use Datatables;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    public function index()
    {
        return view('front.prestamo');
    }

    public function show()
    {
        $prestamos = DB::table('prestamos')->leftJoin('usuarios', 'usuarios.id', '=', 'prestamos.id_usuario')
        ->leftJoin('libros', 'libros.id', '=', 'prestamos.id_libro')
        ->select('prestamos.*', DB::raw('concat(usuarios.nombre, " - ",usuarios.identificacion ) as usuario'), 
        DB::raw('concat(libros.titulo, " - ",libros.autor ) as libro'))->get();

        return Datatables($prestamos)->toJson();
    }


    public function store(Request $request)
    {                
        $libro = DB::table('libros')->where('id','=',$request['idLibro'])->get();
        $cantPresta = DB::table('prestamos')->where('id_libro','=',$request['idLibro'])->get();

        if(count($cantPresta) == $libro[0]->cantidad){
            $Respuesta = array("0","Todos los ejemplares del libro seleccionado estan prestados");
            return response()->json($Respuesta);
        }else{
            $prestamos = new prestamos();
            $prestamos->id_libro = $request['idLibro'];
            $prestamos->id_usuario = $request['idUsuario'];
            $prestamos->fecha_prestamo = now();
            $prestamos->save();    
            
            $Respuesta = array("1","Registro almacenado correctamente");
            return response()->json($Respuesta);
        }
    }

    public function update(Request $request, $id)
    {
		$prestamos = prestamos::findOrFail($id);
        $prestamos->observacion = $request['observacion'];        
        $prestamos->fecha_devolucion = now();
        $prestamos->save();
        
        return 'Registro modificado correctamente' ;
    }

}
