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
                                                <td class="text-center tdImg">
                                                    @if($docente->imagDocente)
                                                        <img src="{{ asset('storage/'.$docente->imagDocente) }}" 
                                                            alt="Imagen del docente" class="img-thumbnail">
                                                    @else
                                                        <img src="{{ asset('images/default.png') }}" 
                                                            alt="Sin imagen" class="img-thumbnail">
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $docente->CodigoDocente }}</td>
                                                <td class="tdNombre">{{ $docente->NomDocente }}</td>
                                                <td class="tdApp">{{ $docente->AppDocente }}</td>
                                                <td class="tdApm">{{ $docente->ApmDocente }}</td>
                                                <td>{{ $docente->emailDocente }}</td>
                                                <td>{{ $docente->FechaNacDocente }}</td>
                                                <td class="text-center">
                                                    @if ($docente->SexoDocente === 'M')
                                                        <span class="badge badge-primary"><i class="fas fa-male"></i> Masculino</span>
                                                    @elseif ($docente->SexoDocente === 'F')
                                                        <span class="badge badge-success"><i class="fas fa-female"></i> Femenino</span>
                                                    @else
                                                        <span class="badge badge-secondary"><i class="fas fa-genderless"></i> Prefiere no decirlo</span>
                                                    @endif
                                                </td>
                                                <td>{{ $docente->GradoEstudioDocente }}</td>
                                                <td>{{ $docente->CiudadDocente }}</td>
                                                <td>{{ $docente->DirDocente }}</td>
                                                <td class="tdTel">{{ $docente->NumTelefonoDocente }}</td>
                                                <td class="text-center estadoDocente">
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
                                                    <button class="btn btn-sm btn-success" 
                                                            title="Cambiar Estado"
                                                            onclick="toggleEstadoDocente('{{ $docente->idDocente }}', '{{ $docente->NomDocente }} {{ $docente->AppDocente }} {{ $docente->ApmDocente }}')">
                                                        <i id="iconEstado{{ $docente->idDocente }}" 
                                                        class="fas {{ $docente->estadoDocente ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                    </button>
                                                    <!-- Botón Eliminar -->
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

    <!-- Modal de edición estilo Large Modal -->
    <div class="modal fade" id="editDocenteModal" tabindex="-1" role="dialog" aria-labelledby="editDocenteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"><!-- modal-lg para tamaño grande -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editDocenteModalLabel">Editar Alumno</h4>
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
                                <label for="txtAppDocente">Apellido 1</label>
                                <input type="text" class="form-control" id="txtAppDocente" name="txtAppDocente">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="txtApmDocente">Apellido 2</label>
                                <input type="text" class="form-control" id="txtApmDocente" name="txtApmDocente">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="txtImagen">Imagen</label>
                                <input type="file" class="form-control" id="txtImagen" name="txtImagen" accept="image/*">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between"><!-- footer con espaciado -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary"
                        onclick="updateDocente($('#editDocenteModal').data('idDocente'));">Guardar cambios</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal Cambiar Estado -->
    <div class="modal fade" id="estadoDocenteModal" tabindex="-1" role="dialog" aria-labelledby="estadoDocenteLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="estadoDocenteLabel">
                        Cambiar Estado del Alumno <span id="nombreDocenteEstado" class="font-weight-bold"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Radios centrados -->
                    <div class="form-group d-flex justify-content-center">
                        <div class="icheck-success d-inline mr-3">
                            <input type="radio" id="radioActivo" name="estadoDocente" value="1">
                            <label for="radioActivo">Activo</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input type="radio" id="radioInactivo" name="estadoDocente" value="0">
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
    <script src="{{ asset('viewresources/docente/insert.js?=27092025') }}"></script>
    <script src="{{ asset('viewresources/docente/delete.js?=27092025') }}"></script>
    <script src="{{ asset('viewresources/docente/update.js?=27092025') }}"></script>
    <script src="{{ asset('viewresources/docente/state.js?=27092025') }}"></script>
@endsection