<?php

use App\libros;
use Illuminate\Database\Seeder;

class LibrosTableSeeder extends Seeder
{
    public function run()
    {
		$libros = new libros();
        $libros->titulo = 'Divina comedia';
        $libros->autor = 'Dante Alighieri';
        $libros->isbn = 'DV-3344';
        $libros->categoria = 'Ficcion';
        $libros->cantidad = 5;
        $libros->fecha_publicacion = '1321-01-01';
        $libros->save();

		$libros = new libros();
        $libros->titulo = 'Don Quijote de la Mancha';
        $libros->autor = 'Miguel de Cervantes';
        $libros->isbn = 'QM-0981';
        $libros->categoria = 'Poema';
        $libros->cantidad = 5;
        $libros->fecha_publicacion = '1605-01-01';
        $libros->save();

		$libros = new libros();
        $libros->titulo = 'El viejo y el mar';
        $libros->autor = 'Ernest Hemingway';
        $libros->isbn = 'VM-1531';
        $libros->categoria = 'Relato';
        $libros->cantidad = 5;
        $libros->fecha_publicacion = '1952-01-01';
        $libros->save();        
    }
}