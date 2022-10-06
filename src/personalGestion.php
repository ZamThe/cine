<?php

    //** HEADER BACKEND
    session_start();

    require 'database/database.php';

    //Establecer zona horario y variables de hora/fecha actual
    date_default_timezone_set('America/Bogota');
    $fechaActual = date("y-m-d");
    $horaActual = date("H:i:s", time()); 

    //Verificar si existe una sesion de lo contrario sera redireccionado al login
    if(!isset($_SESSION['idUsuario'])) {
        echo "<script>location.href='logout.php';</script>";
    }else {
        $idUsuario = $_SESSION['idUsuario'];
        //Capturar el rol que tiene permitidio el usuario 
        $permisos = $_SESSION['permisos'];
    }

    //Traer información sobre el usuario 
    $traerDatosUsuario = $connect->prepare("SELECT * FROM users WHERE id = '$idUsuario'");
    if($traerDatosUsuario->execute()){
        $usuario = $traerDatosUsuario->fetch(PDO::FETCH_ASSOC);
        //print_r($usuario);
    }

?>
<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Control de activiades de Agricola" />
        <meta name="author" content="Mateo Guio" />
        <meta name="keywords" content="Agricola del Caribe, Control de actividades, Control de erradicadores">
        <title>Control de actividades - Agricola del Caribe</title>
        <!-- Favicon-->
        <!--<link rel="icon" type="image/x-icon" href="img/logoSolo.ico"/>-->
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Animations css -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <!-- Bs icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <!-- Main css -->
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body class="bg-main">
        <nav class="navbar navbar-expand-lg bg-dark navbar-light border-bottom border-4 opacity9 w-100">
            <div class="container p-2">
                <a class="navbar-brand fs-6 text-light" href="homeUser.php"> <i class="bi bi-house-door-fill fs-5 text-light"></i> Inicio </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list text-light fs-5"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li><a class="dropdown-item text-light fs-6" href="dashboard.php"><i class="bi bi-arrow-left-square-fill fs-5"></i> Atras</a></li>
                        <li><a class="dropdown-item text-light fs-6" href="#"><i class="bi bi-person-circle fs-5"></i> <?php echo ' '.$usuario['name']; ?> </a></li>
                        <li><a class="dropdown-item text-light fs-6" href="logout.php"><i class="bi bi-door-open-fill fs-5"></i> Salir</a></li>
                        <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle text-white fs-4"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item text-black" href="nosotros.php">Mateo</a></li>
                                <li><a class="dropdown-item text-black" href="nosotros.php">amgm@gmail.com</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </div>            
            </div>
        </nav>
        <div class="bg-success w-100 text-center">
            <p class="text-white fw-bold fs-6 p-3">Personal Gestión</p>
        </div>
        <div class="container">
            <div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg opacity9">
                <div class="row justify-content-around mt-3">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 text-center">
                        <a href="registrarPersonal.php">
                            <button type="button" class="btn btn-success">Registrar personal</button>
                        </a>
                    </div>
                </div>            
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-12 col-xl-12">
                        <hr class="bg-success" style="height: 5px;">
                    </div>
                </div> 
                <!--<div class="row justify-content-center mt-3">
                    <div class="col-4 col-lg-4 col-xl-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-dark text-white">Total ejecutados</span>
                            <input type="text" class="form-control bg-warning text-dark fw-bold" id="totalEjecutado" placeholder="" value="" readonly style="border:0px">
                        </div>
                    </div>
                    <div class="col-4 col-lg-4 col-xl-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-dark text-white">Total en tabla</span>
                            <input type="text" class="form-control bg-warning text-dark fw-bold" id="totalEnVista" placeholder="" value="" readonly style="border:0px">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-12 col-xl-12">
                        <hr class="bg-primary" style="height: 5px;">
                    </div>
                </div>--> 
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="table-responsive p-2">
                            <table class="table table-dark table-striped table-bordered mb-2" id="tablaPersonal" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                        <th>Cargo</th>
                                        <th>Tipo Contrato</th>
                                        <th>Antiguedad</th>
                                        <th>T.Buso</th>
                                        <th>Pantalon</th>
                                        <th>Botas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td valign="middle" align="center"></td>
                                        <td valign="middle" align="center"></td>
                                        <td valign="middle" align="center"></td>
                                        <td valign="middle" align="center"></td>
                                        <td valign="middle" align="center"></td>
                                        <td valign="middle" align="center"></td>
                                        <td valign="middle" align="center"></td>
                                        <td valign="middle" align="center"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- /div -->
        </div>
        <!-- link rel="stylesheet" href="{{ asset('css/app.css') }}" -->
        <script type="text/javascript">

            //Definir formatter de pesos
            const formatterPeso = new Intl.NumberFormat('es-CO',
            {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            //Funcion que formatea valores a pesos
            function formatear_valores_pesos (valor)
            {
                return formatterPeso.format(valor);
            }

            //Inicializar data table
            let tablaAuto = $("#tablaPersonal").DataTable({
                columnDefs: [
                    {"targets": [6], data: null},
                ],
                columns: [
                    {data: "idRequerimiento", title: 'ID Aut.'},
                    {data: "departamento", title: 'Departamento'},
                    {data: "municipio", title: 'Municipio'},
                    {data: "pax", title: 'Pax Aloja'},
                    {data: "paxDesayuno", title: 'Pax D'},
                    {data: "paxAlmuerzo", title: 'Pax A'},
                    {data: "paxCena", title: 'Pax C'},
                    {data: "dias", title: 'Días'},
                    {data: "precioTotal", title: 'Precio'},
                    {data: "fechaRadicacion", title: 'Fecha radicado'},
                    {data: "fechaCheckin", title: 'Fecha inicio'},
                    {data: "fechaCheckout", title: 'Fecha fín'},
                    {data: $(this), title: 'Operaciones'}
                ],
                paging: false
            })

            //Funcion que llena la tabla con los parametros de fechas y estado
            function llenarTabla () {

                var criterios = {};

                if ($('#estado').val() != '')
                    criterios.estado = $('#estado').val();
                else if ($('#fechaInicio').val() == '' && $('#fechaFinal').val() == '') {
                    $('.progress').parent().parent().show();
                    return false;
                }

                if ($('#fechaInicio').val() != '')
                    criterios.fechaInicio = $('#fechaInicio').val();
                else if ($('#estado').val() == '' && $('#fechaFinal').val() == '') {
                    $('.progress').parent().parent().show();
                    return false;
                }

                if ($('#fechaFinal').val() != '')
                    criterios.fechaFinal = $('#fechaFinal').val();
                else  if ($('#estado').val() == '' && $('#fechaInicio').val() == '') {
                    $('.progress').parent().parent().show();
                    return false;
                }

                $.ajax({
                url: '/api/busquedaRequerimientos',
                type: 'POST',
                data: criterios,
                dataType: 'json',
                })
                .done( function(r) {
                    //var d = $.parseJSON(r);
                    $('.progress').parent().parent().hide();
                    //Contar resultados
                    let cantidadMostrados = Object.keys(r).length;
                    //Mostrar resultados
                    //console.log(cantidadMostrados)
                    //Poner el total en el contador
                    $("#totalEnVista").val(cantidadMostrados)

                    $.each(r, function (posicion, autorizacion) {
                        //console.log(autorizacion);
                        //Este metodo te elimina las filas actuales
                        //tablaAuto.rows().remove().draw();
                        //tablaAuto.rows.hide();
                        //Agregar filas
                        //tablaAuto.rows.add(r, $('.progress [idRequerimiento="'+r.idRequerimiento+'"]').html()).draw();
                        //tablaAuto.rows().add(r);

                        $('.progress[idrequerimiento="'+autorizacion.idRequerimiento+'"]').parent().parent().show();
                    });
                })
                .fail( function() {
                    console.log('error')
                });
            }

            
        </script>
    </body>
</html>

