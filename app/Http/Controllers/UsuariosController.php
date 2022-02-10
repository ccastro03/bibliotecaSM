<?php

namespace App\Http\Controllers;

use App\usuarios;
use Response;
use DB;
use Datatables;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function index()
    {
        return view('admin.usuarios');
    }

    public function show()
    {
        $usuarios = DB::table('usuarios')->get();

        return Datatables($usuarios)->toJson();
    }

    public function store(Request $request)
    {
		$usuarios = new usuarios();
        $usuarios->nombre = $request['nombre'];
        $usuarios->identificacion = $request['identificacion'];
        $usuarios->telefono = $request['telefono'];
        $usuarios->email = $request['email'];
        $usuarios->save();
        
        return 'Registro almacenado correctamente' ;
    }

    public function update(Request $request, $id)
    {
		$usuarios = usuarios::findOrFail($id);
        $usuarios->nombre = $request['nombre'];
        $usuarios->identificacion = $request['identificacion'];
        $usuarios->telefono = $request['telefono'];
        $usuarios->email = $request['email'];
        $usuarios->save();
        
        return 'Registro modificado correctamente' ;
    }

    public function destroy(Request $request, $id)
    {
		$usuarios = usuarios::findOrFail($id);
        $usuarios->delete();
        
        return 'Registro eliminado correctamente' ;
    }

    public function listUsuarios(Request $request)
    { 
        $usuarios = usuarios::where('nombre', 'LIKE', '%'.$request->busqueda.'%')->get();

        if(count($usuarios) == 0){
            $usuarios = usuarios::where('identificacion', 'LIKE', '%'.$request->busqueda.'%')->get();
        }

        $response = array();
        foreach($usuarios as $id){
            $response[] = array(
                "id"=>$id->id,
                "text"=>$id->nombre,
            );
        }        

        return response()->json($response);
    }
}
