<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grado_seccion', function (Blueprint $table) {
            $table->string('idGradoSeccion', 13)->primary(); // ID como varchar de 13
            $table->string('nomGrado');
            $table->string('nomSeccion'); // corregido typo: 'nomSessicion' -> 'nomSeccion'
            $table->string('estadoGradoSeccion');
            $table->timestamps(); // crea created_at y updated_at automáticamente
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grado_seccion');
    }
};

