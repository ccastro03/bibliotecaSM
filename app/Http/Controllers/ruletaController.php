<?php

namespace App\Http\Controllers;

use DB;
use Response;
use App\jugadores;
use App\rondas_detalle;
use App\rondas_maestro;
use Illuminate\Http\Request;

class ruletaController extends Controller
{
    public function index()
    {
        $jugadores = DB::table('jugadores')->where("dinero",">",0)->get();
        $numeros = DB::table('numeros')->get();
        $verifronda = DB::table('rondas_maestro')->orderBy('id', 'desc')->get();

        $rondetalle = DB::table('rondas_detalle')->leftjoin('jugadores', 'jugadores.id', '=', 'rondas_detalle.id_jugador')
        ->leftjoin('numeros', 'numeros.id', '=', 'rondas_detalle.id_numero')
        ->select('rondas_detalle.*', 'jugadores.nombre as jugador', 'numeros.numero as numero')->get();
        
        if( count($verifronda) > 0){
            if($verifronda[0]->resultado != null){
                $newronda = new rondas_maestro();
                $newronda->save();
            }
        }else{
            $newronda = new rondas_maestro();
            $newronda->save();            
        }

        $ronda = DB::table('rondas_maestro')->orderBy('id', 'desc')->get();
        $countDetalle = DB::table('rondas_detalle')->where("id_ronda","=",$ronda[0]->id)->count();

        return view('front.ruleta', [
            'jugadores' => $jugadores,
            'numeros' => $numeros,
            'ronda' => $ronda,
            'rondetalle' => $rondetalle,
            'countDetalle' => $countDetalle,
        ]);
    }

    public function hacerApuesta(Request $request)
    {
        $rondas_detalle = new rondas_detalle();
        $rondas_detalle->id_ronda = $request['ractual'];
        $rondas_detalle->id_jugador = $request['jugador'];
        $rondas_detalle->id_numero = $request['numero'];
        $rondas_detalle->valor_apuesta = $request['vlrApuesta'];
        $rondas_detalle->save();

		$jugadores = jugadores::findOrFail($request['jugador']);
        $jugadores->dinero = $jugadores->dinero - $request['vlrApuesta'];
        $jugadores->save();        

        return 'Apuesta realizada correctamente' ;        
    }

    public function resultadoGiro(Request $request)
    {
        $verrd = DB::table('rondas_maestro')->where("id","=",$request['ractual'])->get();
        
        $rondetalle = DB::table('rondas_detalle')->where("id_ronda","=",$request['ractual'])->get();

        if( count($rondetalle) > 0){        
            if($verrd[0]->resultado == null){
            
                $rondas_maestro = rondas_maestro::findOrFail($request['ractual']);
                $rondas_maestro->resultado = $request['numcayo'];
                $rondas_maestro->save();        

                $rondetalle = DB::table('rondas_detalle')->where("id_ronda","=",$request['ractual'])->get();

                if( count($rondetalle) > 0){
                    foreach($rondetalle as $rd){
                        $numero = DB::table('numeros')->where("numero","=",$request['numcayo'])->get();

                        if($rd->id_numero == $numero[0]->id){                
                            if($numero[0]->color == '#00b347'){
                                $resultado = ($rd->valor_apuesta * 10);
                            }else{
                                $resultado = ($rd->valor_apuesta * 2);                    
                            }

                            $rondas_detalle = rondas_detalle::findOrFail($rd->id);
                            $rondas_detalle->tipo_resultado = 'WIN';
                            $rondas_detalle->valor_resultado = $resultado;
                            $rondas_detalle->save();                
                        }else{
                            $rondas_detalle = rondas_detalle::findOrFail($rd->id);                
                            $rondas_detalle->tipo_resultado = 'LOSE';
                            $rondas_detalle->valor_resultado = -$rd->valor_apuesta;
                            $rondas_detalle->save();                 
                        }
                    }
                }

                return 'Resultado agregado correctamente';
            }else{
                return 'Ronda ya jugada';
            }
        }
    }
}
