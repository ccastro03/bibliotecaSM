<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsuariosTableSeeder::class);
        $this->call(LibrosTableSeeder::class);
    }
}
