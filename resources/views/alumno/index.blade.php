@extends('template.layout')
@section('titleGeneral', 'Lista de Alumnos')
@section('sectionGeneral')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <style>
        thead {
            background-color: #007bff;
            /* Azul Bootstrap */
            color: white;
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('titleGeneral')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Alumno</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <!-- Botón Agregar Alumno -->
                                    <a href="{{ url('alumno/insert') }}" class="btn btn-primary mr-2">
                                        <i class="fas fa-plus"></i> Agregar Alumno
                                    </a>
                                    <!-- Botón Subir Archivo -->
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#modalSubirArchivo">
                                        <i class="fas fa-upload"></i> Subir Archivo
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="all">Nro.</th>
                                            <th class="none">Cuenta</th>
                                            <th>Nombre</th>
                                            <th>Paterno</th>
                                            <th>Materno</th>
                                            <th class="none">Correo</th>
                                            <th class="none">Fecha de nacimineto</th>
                                            <th>Genero</th>
                                            <th class="none">Ciudad</th>
                                            <th class="none">Direccion</th>
                                            <th>Telefono</th>
                                            <th>Estado</th>
                                            <th class="none">Registrado</th>
                                            <th class="all">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listAlumnos as $alumno)
                                            <tr id="alumnoRow{{ $alumno->idAlumno }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $alumno->codAlumno }}</td>
                                                <td class="tdNombre">{{ $alumno->NomAlumno }}</td>
                                                <td class="tdApp">{{ $alumno->AppAlumno }}</td>
                                                <td class="tdApm">{{ $alumno->ApmAlumno }}</td>
                                                <td>{{ $alumno->EmailAlumno }}</td>
                                                <td>{{ $alumno->FechaNaciAlumno }}</td>
                                                <td class="text-center">
                                                    @if ($alumno->SexoAlumno === 'M')
                                                        <span class="badge badge-primary"><i class="fas fa-male"></i>
                                                            Masculino</span>
                                                    @elseif ($alumno->SexoAlumno === 'F')
                                                        <span class="badge badge-success"><i class="fas fa-female"></i>
                                                            Femenino</span>
                                                    @else
                                                        <span class="badge badge-secondary"><i
                                                                class="fas fa-genderless"></i> Prefiere no decirlo</span>
                                                    @endif
                                                </td>
                                                <td>{{ $alumno->CiudadAlumno }}</td>
                                                <td>{{ $alumno->DirAlumno }}</td>
                                                <td class="tdTel">{{ $alumno->TelAlumno }}</td>
                                                <td class="text-center">
                                                    @if ($alumno->ActivoAlumno)
                                                        <span class="badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $alumno->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="text-center">
                                                    <!-- Botón Editar -->
                                                    <button class="btn btn-sm btn-warning"
                                                        title="{{ $alumno->ActivoAlumno ? 'Editar' : 'Inactivo: no se puede editar' }}"
                                                        onclick="showEditModal(
                                                            '{{ $alumno->idAlumno }}',
                                                            '{{ $alumno->NomAlumno }}',
                                                            '{{ $alumno->AppAlumno }}',
                                                            '{{ $alumno->ApmAlumno }}',
                                                            '{{ $alumno->TelAlumno }}'
                                                        )"
                                                        data-toggle="modal" data-target="#editAlumnoModal"
                                                        @if (!$alumno->ActivoAlumno) disabled @endif>
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Botón Cambiar Estado -->
                                                    <button class="btn btn-sm btn-success" title="Cambiar Estado"
                                                        onclick="toggleEstadoAlumno('{{ $alumno->idAlumno }}', '{{ $alumno->NomAlumno }} {{ $alumno->AppAlumno }} {{ $alumno->ApmAlumno }}')">
                                                        @if ($alumno->ActivoAlumno)
                                                            <i class="fas fa-toggle-on"></i>
                                                        @else
                                                            <i class="fas fa-toggle-off"></i>
                                                        @endif
                                                    </button>

                                                    <!-- Botón Eliminar -->
                                                    <button class="btn btn-sm btn-danger"
                                                        title="{{ $alumno->ActivoAlumno ? 'Eliminar' : 'Inactivo: no se puede eliminar' }}"
                                                        onclick="deleteAlumno('{{ $alumno->idAlumno }}')"
                                                        @if (!$alumno->ActivoAlumno) disabled @endif>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- Modal de edición estilo Large Modal -->
    <div class="modal fade" id="editAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="editAlumnoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"><!-- modal-lg para tamaño grande -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editAlumnoModalLabel">Editar Alumno</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="txtNombre">Nombre</label>
                                <input type="text" class="form-control" id="txtNombre" name="txtNombre">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="txtTele">Teléfono</label>
                                <input type="text" class="form-control" id="txtTele" name="txtTele">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="txtAppAlumno">Apellido 1</label>
                                <input type="text" class="form-control" id="txtAppAlumno" name="txtAppAlumno">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="txtApmAlumno">Apellido 2</label>
                                <input type="text" class="form-control" id="txtApmAlumno" name="txtApmAlumno">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between"><!-- footer con espaciado -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary"
                        onclick="updateAlumno($('#editAlumnoModal').data('idAlumno'));">Guardar cambios</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal Cambiar Estado -->
<div class="modal fade" id="estadoAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="estadoAlumnoLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="estadoAlumnoLabel">
                    Cambiar Estado del Alumno <span id="nombreAlumnoEstado" class="font-weight-bold"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Radios centrados -->
                <div class="form-group d-flex justify-content-center">
                    <div class="icheck-success d-inline mr-3">
                        <input type="radio" id="radioActivo" name="estadoAlumno" value="1">
                        <label for="radioActivo">Activo</label>
                    </div>
                    <div class="icheck-danger d-inline">
                        <input type="radio" id="radioInactivo" name="estadoAlumno" value="0">
                        <label for="radioInactivo">Inactivo</label>
                    </div>
                </div>

                <!-- Mensaje dinámico -->
                <div id="estadoMensaje" class="text-center font-weight-bold text-muted small mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarEstado">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<style >
#estadoMensaje {
    background: #e8f4fc;            /* celeste suave por defecto */
    color: #0c5460;                /* azul oscuro legible */
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 500;
    line-height: 1.4;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease-in-out;
}
#estadoMensaje.success {
    background: #e6f9f0;           /* verde suave */
    color: #155724;
}
#estadoMensaje.danger {
    background: #fdecea;           /* rojo suave */
    color: #721c24;
}

</style>

@endsection

@section('js')
    <script src="{{ asset('viewresources/alumno/update.js?=6092025') }}"></script>
    <script src="{{ asset('viewresources/alumno/delete.js?=6092025') }}"></script>
    <script src="{{ asset('viewresources/alumno/update.js?=6092025') }}"></script>
    <script src="{{ asset('viewresources/alumno/state.js?=6092025') }}"></script>
@endsection
