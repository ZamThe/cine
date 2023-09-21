<?php

    //** HEADER BACKEND
    session_start();

    require 'database/database.php';
    //require '../vendor/autoload.php';

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

    //Traer los registros de personal_labores 
    $traerPersonalLabores = $connect->prepare("SELECT pl.id, ps.nombre as nombrePersonal, lb.nombre_labor as nombreLabor, pl.cantidad, pl.valor_total, pl.fecha_realizacion as fecha FROM personal_labores pl INNER JOIN personal ps ON pl.id_personal = ps.id INNER JOIN labores lb ON pl.id_labor = lb.id");
    if($traerPersonalLabores->execute()){
        $guardarPersonalLabores = $traerPersonalLabores->fetchAll(PDO::FETCH_ASSOC);
    }

    //Traer personal 
    $traerPersonal = $connect->prepare("SELECT * FROM personal ORDER BY nombre ASC");
    if($traerPersonal->execute()){
        $guardarPersonal = $traerPersonal->fetchAll(PDO::FETCH_ASSOC);
    }

    //Instanciar formateador de numeros 
    $fmt = new \NumberFormatter('es_CO', \NumberFormatter::CURRENCY);

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
        <link rel="icon" type="image/x-icon" href="assets/img/AGRICONTROL.ico"/>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- Bs icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Main css -->
        <link rel="stylesheet" href="css/styles.css">
        <style>
            .select2-selection__rendered {
                line-height: 35px !important;
            }
            .select2-container .select2-selection--single {
                height: 36px !important;
            }
            .select2-selection__arrow {
                height: 36px !important;
            }
        </style>
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
                        <li><a class="dropdown-item text-light fs-6 me-3" href="dashboard.php"><i class="bi bi-arrow-left-square-fill fs-5"></i> Atras</a></li>
                        <li><a class="dropdown-item text-light fs-6 me-3" href="#"><i class="bi bi-person-circle fs-5"></i> <?php echo ' '.$usuario['name']; ?> </a></li>
                        <li><a class="dropdown-item text-light fs-6 me-3" href="logout.php"><i class="bi bi-door-open-fill fs-5"></i> Salir</a></li>
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
            <p class="text-white fw-bold fs-6 p-3">Labores - personal detalle</p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                    <div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg opacity9 rounded">
                        <div class="row justify-content-center align-items-center text-center mt-3">
                            <h6 class="h6 text-white">Busqueda de personal por cedula</h6>
                        </div>
                        <form action="informes/reportePorCedula.php" method="POST">
                            <div class="row justify-content-center mt-3 mb-3">
                                <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-4 text-center">
                                    <select id="seleccionarCedula" class="form-select" name="cedula">
                                        <?php
                                        
                                            foreach ($guardarPersonal as $gp) {
                                                echo '<option value="'.$gp['identificacion'].'">'.$gp['identificacion'].' - '.$gp['nombre'].'</option>';
                                            }

                                        ?>
                                    </select>
                                    <!-- <input type="text" class="form-control" name="cedula" placeholder="Ingrese una cedula">-->
                                    <input type="hidden" name="reportePorSoloCedula" value="1">
                                </div>
                                <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-1 text-center">
                                    <button type="submit" class="btn btn-success"><i class="bi bi-eye-fill"></i></button>
                                </div>
                            </div>            
                        </form>
                        <!--<div class="row justify-content-center">
                            <div class="col-12 col-lg-12 col-xl-12">
                                <hr class="bg-success" style="height: 5px;">
                            </div>
                        </div> 
                        <div class="row justify-content-center align-items-center text-center mt-1">
                            <h6 class="h6 text-white">Busqueda por fecha y cedula de labores realizadas </h6>
                        </div>
                        <form action="informes/reportePorCedula.php" method="POST">
                            <div class="row justify-content-center mt-3">
                                <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-4 text-center">
                                    <input type="text" class="form-control" placeholder="Ingrese una cedula">
                                </div>
                                <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-3 text-center">
                                    <input type="date" class="form-control" placeholder="Ingrese la fecha de ingreso">
                                </div>
                                <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-3 text-center">
                                    <input type="date" class="form-control" placeholder="Ingrese la fecha de ingreso">
                                </div>
                                <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-1 text-center">
                                    <button type="submit" class="btn btn-success"><i class="bi bi-eye-fill"></i></button>
                                </div>
                            </div> 
                        </form>
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-12 col-xl-12">
                                <hr class="bg-success" style="height: 5px;">
                            </div>
                        </div> 
                        <div class="row justify-content-center align-items-center text-center mt-1">
                            <h6 class="h6 text-white">Busqueda por fecha de labores realizadas</h6>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-3 text-center">
                                <input type="date" class="form-control" placeholder="Ingrese la fecha de ingreso">
                            </div>
                            <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-3 text-center">
                                <input type="date" class="form-control" placeholder="Ingrese la fecha de ingreso">
                            </div>
                            <div class="col-10 col-sm-10 col-md-5 col-lg-4 col-xl-1 text-center">
                                <button type="submit" class="btn btn-success"><i class="bi bi-eye-fill"></i></button>
                            </div>
                        </div> 
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-12 col-xl-12">
                                <hr class="bg-success" style="height: 5px;">
                            </div>
                        </div> -->
                    </div>            
                </div>
            </div>
        </div>
        <!-- Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <!-- Select2 bower -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- Sweet alert -->
        <!--<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>-->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Numeros a letras -->
        <script src="js/numeroALetras.js"></script>
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

            window.addEventListener("load", function(event) {

                //Activar select2
                $("#seleccionarCedula").select2()
            });


            //Inicializar data table
            /*let tablaAuto = $("#tablaPersonal").DataTable({
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
            })*/

            //Funcion que llena la tabla con los parametros de fechas y estado
            /*function llenarTabla () {

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
            }*/

            
        </script>
    </body>
</html>

