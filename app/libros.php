<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class libros extends Model
{
    protected $fillable = [
        'titulo', 'autor', 'isbn', 'categoria', 'cantidad', 'fecha_publicacion'
    ];

    protected $table = 'libros';
    protected $primaryKey = "id";
}
