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
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Small boxes (Stat box) -->
                                <div class="row">
                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <h3>150</h3>

                                                <p>Registros de alumnos</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-bag"></i>
                                            </div>
                                            <a  href="{{ url('/alumno') }}" class="small-box-footer">More info <i
                                                    class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3>53<sup style="font-size: 20px">%</sup></h3>

                                                <p>Registro de Docentes</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-stats-bars"></i>
                                            </div>
                                            <a href="{{ url('/docente') }}" class="small-box-footer">More info <i
                                                    class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-warning">
                                            <div class="inner">
                                                <h3>44</h3>

                                                <p>Registro de Cursos</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-person-add"></i>
                                            </div>
                                            <a href="#" class="small-box-footer">More info <i
                                                    class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-danger">
                                            <div class="inner">
                                                <h3>65</h3>

                                                <p>Unique Visitors</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-pie-graph"></i>
                                            </div>
                                            <a href="#" class="small-box-footer">More info <i
                                                    class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                </div>
                            </div><!-- /.container-fluid -->
                        </section>
                        <!-- /.content -->
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

    <style>
        #estadoMensaje {
            background: #e8f4fc;
            /* celeste suave por defecto */
            color: #0c5460;
            /* azul oscuro legible */
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 500;
            line-height: 1.4;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
        }

        #estadoMensaje.success {
            background: #e6f9f0;
            /* verde suave */
            color: #155724;
        }

        #estadoMensaje.danger {
            background: #fdecea;
            /* rojo suave */
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
