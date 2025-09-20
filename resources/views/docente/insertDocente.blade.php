@extends('template.layout')
@section('titleGeneral', 'Insertar Nuevo Docente')
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
                            <li class="breadcrumb-item"><a href="#">Docente</a></li>
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
                        <h3 class="card-title">Datos del Docente</h3>
                    </div>
                    <!-- Body -->
                    <div class="card-body">
                        <form id="frmDocenteInsert" action="{{ url('docente/insertDocente') }}" method="post"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Codigo del alumno -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Codigo del docente:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-key"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtCodigo" name="txtCodigo"
                                                placeholder="Ingrese el codigo" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Tipo de documento -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de Documento:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-id-card"></i>
                                                </div>
                                            </div>
                                            <select class="form-control" id="tipoDocumento" name="txttipoDocumento" required>
                                                <option value="" disabled selected>Seleccione...</option>
                                                <option value="DNI">DNI</option>
                                                <option value="PASAPORTE">Pasaporte</option>
                                                <option value="CARNET">Carnet de Extranjería</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Número de documento -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Número de Documento:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-hashtag"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtDocumento" name="txtDocumento"
                                                placeholder="Seleccione un tipo de documento" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Apellido Nombres -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombres:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtNombre" name="txtNombre"
                                                placeholder="Ingrese el nombre" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Apellido Paterno -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Apellido Paterno:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtAppDocente" name="txtAppDocente"
                                                placeholder="Ingrese el apellido paterno" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Apellido Materno -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Apellido Materno:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtApmDocente" name="txtApmDocente"
                                                placeholder="Ingrese el apellido materno" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Fecha de nacimiento -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtNacimiento">Fecha de Nacimiento:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <div class="input-group-prepend" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input"
                                                id="txtNacimiento" name="txtNacimiento" data-target="#reservationdate"
                                                placeholder="dd/mm/yyyy" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Sexo -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtSexo">Sexo:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-venus-mars"></i></div>
                                            </div>
                                            <select class="form-control" id="txtSexo" name="txtSexo" required>
                                                <option value="">Seleccione una opción</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                                <option value="N">Prefiere no decirlo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Grado de estudio -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Grado de estudio:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-user-graduate"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtGradoEstudio" name="txtGradoEstudio"
                                                placeholder="Ingrese el grado de estudio" />
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Ciudad -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ciudad:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-city"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtCiudad" name="txtCiudad"
                                                placeholder="Ingrese la ciudad" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Direccion -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dirección:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-home"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="txtDireccion"
                                                name="txtDireccion" placeholder="Ingrese el campo Direccion" />
                                        </div>
                                    </div>
                                </div>
                                <!-- correo electronico -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Correo electrónico:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                            </div>
                                            <input type="email" class="form-control" id="txtEmail" name="txtEmail"
                                                class="form-control" placeholder="Ingrese el correo electronico" />
                                        </div>
                                    </div>
                                </div>
                                <!-- phone mask -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Numero de teléfono:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="txtTele" name="txtTele"
                                                placeholder="Ingrese el campo telefono">
                                        </div>
                                    </div>
                                </div>
                                <!-- Subir Imagen -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subir Imagen:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-image"></i>
                                                </span>
                                            </div>
                                            <input type="file" class="form-control" id="txtImagen" name="txtImagen" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Botón Regresar a la izquierda -->
                                <div class="col-md-6 text-left">
                                    <a href="{{ url('docente') }}" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i> Regresar
                                    </a>
                                </div>
                                <!-- Botón Registrar a la derecha -->
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-primary" onclick="sendFrmDocenteInsert();">
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
    <script>
    document.getElementById('tipoDocumento').addEventListener('change', function() {
        let input = document.getElementById('txtDocumento');
        switch (this.value) {
            case 'DNI':
                input.placeholder = 'Ingrese el DNI';
                break;
            case 'PASAPORTE':
                input.placeholder = 'Ingrese el Pasaporte';
                break;
            case 'CARNET':
                input.placeholder = 'Ingrese el Carnet de Extranjería';
                break;
            default:
                input.placeholder = 'Seleccione un tipo de documento';
        }
    });
</script>
@endsection
@section('js')
    <script src="{{ asset('viewresources/docente/insert.js?=1292025') }}"></script>
@endsection


