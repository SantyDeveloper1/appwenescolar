<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    // Nombre de la tabla en la base de datos
    protected $table = 'cursos';

    // Clave primaria personalizada (idcurso en lugar de id)
    protected $primaryKey = 'idcurso';
    public $incrementing = false;      // No es autoincremental
    protected $keyType = 'string';     // Es VARCHAR, no INT

    // Activamos timestamps (created_at y updated_at)
    public $timestamps = true;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'idcurso',
        'nomCurso',
        'estadoCurso',
    ];
}
