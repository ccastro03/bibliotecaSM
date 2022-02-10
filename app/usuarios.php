<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
    protected $fillable = [
        'nombre', 'identificacion', 'telefono', 'email'
    ];
    
    protected $table = 'usuarios';
    protected $primaryKey = "id";
}