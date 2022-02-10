<?php

use App\usuarios;
use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    public function run()
    {
		$usuarios = new usuarios();
        $usuarios->nombre = 'Carlos Castro';
        $usuarios->identificacion = '123456';
        $usuarios->telefono = '11223344';
        $usuarios->email = 'carloscastro@gmail.com';
        $usuarios->save();
    }
}