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
    Schema::create('docentes', function (Blueprint $table) {
        // ID string de 13 caracteres como primary key
        $table->string('idDocente', 13)->primary();

        $table->string('CodigoDocente', 20)->unique();
        $table->string('codigoOficial', 50)->nullable();

        $table->string('DocDocente', 20)->unique();
        $table->string('NomDocente', 120);
        $table->string('AppDocente', 80);
        $table->string('ApmDocente', 80)->nullable();

        $table->date('FechaNacDocente')->nullable();
        $table->enum('SexoDocente', ['M', 'F', 'Otro', 'N/R'])->default('N/R');

        $table->string('GradoEstudioDocente', 80)->nullable();
        $table->string('CiudadDocente', 100)->nullable();
        $table->string('DirDocente', 200)->nullable();

        $table->string('emailDocente', 150)->unique()->nullable();
        $table->string('NumTelefonoDocente', 30)->nullable();

        $table->boolean('estadoDocente')->default(true);
        $table->string('imagDocente', 255)->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
