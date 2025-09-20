@extends('template.layout')

@section('titleGeneral', 'Lista de Alumnos')

@section('sectionGeneral')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestión de Alumnosdd</h3>
        </div>
        <div class="card-body">
            {{-- Aquí se carga tu componente Livewire --}}
            @livewire('alumno-component')
        </div>
    </div>
@endsection
