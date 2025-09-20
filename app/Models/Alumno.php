<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'alumnos';

    // Clave primaria
    protected $primaryKey = 'idAlumno';

       // Si no usas autoincrement
    public $incrementing = false;

    // Tipo de clave primaria
    protected $keyType = 'string';
    

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'codAlumno',
        'NomAlumno',
        'AppAlumno',
        'ApmAlumno',
        'DNI',
        'EmailAlumno',
        'FechaNaciAlumno',
        'SexoAlumno',
        'CiudadAlumno',
        'DirAlumno',
        'TelAlumno',
        'ActivoAlumno',
    ];
    public $timestamps = true;

}