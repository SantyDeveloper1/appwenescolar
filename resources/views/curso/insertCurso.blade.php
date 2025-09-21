@extends('template.layout')
@section('titleGeneral', 'Insertar Nuevo Curso')
@section('sectionGeneral')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('titleGeneral')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Curso</a></li>
                            <li class="breadcrumb-item active">Insertar</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <!-- Header -->
                    <div class="card-header">
                        <h3 class="card-title">Datos del Curso</h3>
                    </div>
                    <!-- Body -->
                    <div class="card-body">
                        <form id="frmCursoInsert" action="{{ url('curso/insertCurso') }}" method="post">
                            @csrf
                            <div class="row">
                                <!-- nombre del curso -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre del curso:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtNombre" name="txtNombre"
                                                placeholder="Ingrese el nombre del curso" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Botón Regresar a la izquierda -->
                                <div class="col-md-6 text-left">
                                    <a href="{{ url('curso') }}" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i> Regresar
                                    </a>
                                </div>
                                <!-- Botón Registrar a la derecha -->
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-primary" onclick="sendFrmCursoInsert();">
                                        <i class="fa fa-save"></i> Registrar datos
                                    </button>
                                </div>
                            </div>
                    </div>
                </div> <!-- card-body -->
            </div> <!-- card -->
    </div> <!-- container -->
    </section>
    </div>
@endsection
@section('js')
    <script src="{{ asset('viewresources/curso/insert.js?=20092025') }}"></script>
@endsection