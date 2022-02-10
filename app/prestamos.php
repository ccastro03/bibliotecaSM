<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prestamos extends Model
{
    protected $fillable = [
        'id_libro', 'id_usuario', 'fecha_prestamo', 'fecha_devolucion', 'observacion'
    ];
    
    protected $table = 'prestamos';
    protected $primaryKey = "id";
}