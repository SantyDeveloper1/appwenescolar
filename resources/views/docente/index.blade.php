@extends('template.layout')
@section('titleGeneral', 'Lista de Docentes')
@section('sectionGeneral')
    <style>
        thead {
            background-color: #007bff;
            color: white;
        }
        .img-thumbnail {
            max-width: 70px;
            max-height: 70px;
            object-fit: cover;
        }
    </style>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('titleGeneral')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Docente</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <!-- Botón Agregar Docente -->
                                    <a href="{{ url('docente/insertDocente') }}" class="btn btn-primary mr-2">
                                        <i class="fas fa-plus"></i> Agregar Docente
                                    </a>
                                    <!-- Botón Subir Archivo -->
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#modalSubirArchivo">
                                        <i class="fas fa-upload"></i> Subir Archivo
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="all">Nro.</th>
                                            <th>Imagen</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Paterno</th>
                                            <th>Materno</th>
                                            <th class="none">Correo</th>
                                            <th class="none">Fecha Nacimiento</th>
                                            <th>Género</th>
                                            <th class="none">Grado Estudio</th>
                                            <th class="none">Ciudad</th>
                                            <th class="none">Dirección</th>
                                            <th>Teléfono</th>
                                            <th>Estado</th>
                                            <th class="none">Registrado</th>
                                            <th class="all">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listDocentes as $docente)
                                            <tr id="docenteRow{{ $docente->idDocente }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                <!-- 📷 Imagen -->
                                                <td class="text-center">
                                                    @if($docente->imagDocente)
                                                        <img src="{{ asset('storage/'.$docente->imagDocente) }}" 
                                                            alt="Imagen del docente" class="img-thumbnail">
                                                    @else
                                                        <img src="{{ asset('images/default.png') }}" 
                                                            alt="Sin imagen" class="img-thumbnail">
                                                    @endif
                                                </td>

                                                <td class="text-center">{{ $docente->CodigoDocente }}</td>
                                                <td>{{ $docente->NomDocente }}</td>
                                                <td>{{ $docente->AppDocente }}</td>
                                                <td>{{ $docente->ApmDocente }}</td>
                                                <td>{{ $docente->emailDocente }}</td>
                                                <td>{{ $docente->FechaNacDocente }}</td>
                                                <td class="text-center">
                                                    @if ($docente->SexoDocente === 'M')
                                                        <span class="badge badge-primary"><i class="fas fa-male"></i>
                                                            Masculino</span>
                                                    @elseif ($docente->SexoDocente === 'F')
                                                        <span class="badge badge-success"><i class="fas fa-female"></i>
                                                            Femenino</span>
                                                    @else
                                                        <span class="badge badge-secondary"><i class="fas fa-genderless"></i>
                                                            Prefiere no decirlo</span>
                                                    @endif
                                                </td>
                                                <td>{{ $docente->GradoEstudioDocente }}</td>
                                                <td>{{ $docente->CiudadDocente }}</td>
                                                <td>{{ $docente->DirDocente }}</td>
                                                <td>{{ $docente->NumTelefonoDocente }}</td>
                                                <td class="text-center">
                                                    @if ($docente->estadoDocente)
                                                        <span class="badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $docente->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="text-center">
                                                    <!-- Botón Editar -->
                                                    <button class="btn btn-sm btn-warning"
                                                        title="{{ $docente->estadoDocente ? 'Editar' : 'Inactivo: no se puede editar' }}"
                                                        onclick="showEditModal(
                                                            '{{ $docente->idDocente }}',
                                                            '{{ $docente->NomDocente }}',
                                                            '{{ $docente->AppDocente }}',
                                                            '{{ $docente->ApmDocente }}',
                                                            '{{ $docente->NumTelefonoDocente }}'
                                                        )"
                                                        data-toggle="modal" data-target="#editDocenteModal"
                                                        @if (!$docente->estadoDocente) disabled @endif>
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Botón Cambiar Estado -->
                                                    <button class="btn btn-sm btn-success" title="Cambiar Estado"
                                                        onclick="toggleEstadoDocente('{{ $docente->idDocente }}', '{{ $docente->NomDocente }} {{ $docente->AppDocente }} {{ $docente->ApmDocente }}')">
                                                        @if ($docente->estadoDocente)
                                                            <i class="fas fa-toggle-on"></i>
                                                        @else
                                                            <i class="fas fa-toggle-off"></i>
                                                        @endif
                                                    </button>

                                                    <!-- Botón Eliminar -->
                                                    <button class="btn btn-sm btn-danger"
                                                        title="{{ $docente->estadoDocente ? 'Eliminar' : 'Inactivo: no se puede eliminar' }}"
                                                        onclick="deleteDocente('{{ $docente->idDocente }}')"
                                                        @if (!$docente->estadoDocente) disabled @endif>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="{{ asset('viewresources/alumno/update.js?=6092025') }}"></script>
    <script src="{{ asset('viewresources/alumno/delete.js?=6092025') }}"></script>
    <script src="{{ asset('viewresources/alumno/update.js?=6092025') }}"></script>
    <script src="{{ asset('viewresources/alumno/state.js?=6092025') }}"></script>
@endsection