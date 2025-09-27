<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradoSeccion extends Model
{
    use HasFactory;

    protected $table = 'grado_seccion'; // nombre de la tabla

    protected $primaryKey = 'idGradoSeccion'; // clave primaria personalizada
    public $incrementing = false; // porque es varchar
    protected $keyType = 'string';

    protected $fillable = [
        'idGradoSeccion',
        'nomGrado',
        'nomSeccion',
        'estadoGradoSeccion',
    ];

    // Si quieres deshabilitar timestamps manualmente (aunque en migración los tienes)
    // public $timestamps = false;
}

