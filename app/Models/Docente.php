<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Docente extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'docentes';

    // Primary key personalizada
    protected $primaryKey = 'idDocente';
    public $incrementing = false;   // No es autoincrement
    protected $keyType = 'string';  // Es string de 13 caracteres

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'idDocente',
        'CodigoDocente',
        'codigoOficial',
        'DocDocente',
        'NomDocente',
        'AppDocente',
        'ApmDocente',
        'FechaNacDocente',
        'SexoDocente',
        'GradoEstudioDocente',
        'CiudadDocente',
        'DirDocente',
        'emailDocente',
        'NumTelefonoDocente',
        'estadoDocente',
        'imagDocente',
    ];
}
