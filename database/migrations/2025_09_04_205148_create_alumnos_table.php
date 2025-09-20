<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->string('idAlumno', 13); 
            $table->string('codAlumno', 20)->unique(); 
            $table->string('NomAlumno', 100);
            $table->string('AppAlumno', 80);
            $table->string('ApmAlumno',80);
            $table->string('DNI', 15)->unique();
            $table->string('EmailAlumno', 150)->unique();
            $table->date('FechaNaciAlumno')->nullable();
            $table->enum('SexoAlumno', ['M', 'F'])->nullable();
            $table->string('CiudadAlumno', 100)->nullable();
            $table->string('DirAlumno', 200)->nullable();
            $table->string('TelAlumno', 20)->nullable();
            $table->boolean('ActivoAlumno')->default(true);
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
