@extends('template.layout')
@section('titleGeneral', 'Lista de Cursos')
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
                            <li class="breadcrumb-item active">Cursos</li>
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
                                    <!-- Botón Agregar Curso -->
                                    <a href="{{ url('curso/insertCurso') }}" class="btn btn-primary mr-2">
                                        <i class="fas fa-plus"></i> Agregar Curso
                                    </a>
                                    <!-- Botón Subir Archivo -->
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#modalSubirArchivo">
                                        <i class="fas fa-upload"></i> Subir Archivo
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tablaCursos" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="all">Nro.</th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                            <th class="all">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listCursos as $curso)
                                            <tr id="cursoRow{{ $curso->idcurso }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="tdNombre">{{ $curso->nomCurso }}</td>
                                                <td class="text-center">
                                                    @if ($curso->estadoCurso)
                                                        <span class="badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Botón Editar -->
                                                    <button class="btn btn-sm btn-warning"
                                                        title="{{ $curso->estadoCurso ? 'Editar' : 'Inactivo: no se puede editar' }}"
                                                        onclick="showEditModalCurso('{{ $curso->idcurso }}')"
                                                        @if (!$curso->estadoCurso) disabled @endif>
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Botón Cambiar Estado -->
                                                    <button class="btn btn-sm btn-success" title="Cambiar Estado"
                                                        onclick="toggleEstadoCurso('{{ $curso->idcurso }}', '{{ addslashes($curso->nomCurso) }}')">
                                                        @if ($curso->estadoCurso)
                                                            <i class="fas fa-toggle-on"></i>
                                                        @else
                                                            <i class="fas fa-toggle-off"></i>
                                                        @endif
                                                    </button>

                                                    <!-- Botón Eliminar -->
                                                    <button class="btn btn-sm btn-danger"
                                                        title="{{ $curso->estadoCurso ? 'Eliminar' : 'Inactivo: no se puede eliminar' }}"
                                                        onclick="deleteCurso('{{ $curso->idcurso }}')"
                                                        @if (!$curso->estadoCurso) disabled @endif>
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
    <!-- Modal de edición estilo Large Modal -->
    <div class="modal fade" id="editCursoModal" tabindex="-1" role="dialog" aria-labelledby="editCursoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"><!-- modal-lg para tamaño grande -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editCursoModalLabel">Editar Curso</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="txtNombre">Nombre</label>
                                <input type="text" class="form-control" id="txtNombre" name="txtNombre">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between"><!-- footer con espaciado -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary"
                        onclick="updateCurso($('#editCursoModal').data('idCurso'));">Guardar cambios</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Modal Cambiar Estado -->
    <div class="modal fade" id="estadoCursoModal" tabindex="-1" role="dialog" aria-labelledby="estadoCursoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="estadoCursoLabel">
                        Cambiar Estado del Curso <span id="nombreCursoEstado" class="font-weight-bold"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Radios centrados -->
                    <div class="form-group d-flex justify-content-center">
                        <div class="icheck-success d-inline mr-3">
                            <input type="radio" id="radioActivo" name="estadoCurso" value="1">
                            <label for="radioActivo">Activo</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input type="radio" id="radioInactivo" name="estadoCurso" value="0">
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
    <script src="{{ asset('viewresources/curso/update.js?=20092025') }}"></script>
    <script src="{{ asset('viewresources/curso/delete.js?=20092025') }}"></script>
    <script src="{{ asset('viewresources/curso/update.js?=20092025') }}"></script>
    <script src="{{ asset('viewresources/curso/state.js?=20092025') }}"></script>
@endsection