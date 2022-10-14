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

    //Comprobar si se envio el formulario 
    if(isset($_POST['guardarLaborPersonal'])){

        //Capturar personal
        $idPersonal = $_POST['personal'];
        //Capturar labor
        $idLabor = $_POST['labor'];
        //Capturar fecha de ralizacion de la labor 
        $fecha = $_POST['fecha'];
        //Capturar valor individual de la labor
        $valorIndividual = $_POST["valor_laborOculto"];
        //Capturar cantidad 
        $cantidad = $_POST["cantidadActividades"];
        //Capturar valor total 
        $valorTotal = $_POST["valorTotalOculto"];
        //Capturar fecha de realización
        $fechaRealizacion = $_POST["fecha"];

        //Preparar sentencia 
        $relacionarLaborPersonal = $connect->prepare("INSERT INTO personal_labores (id_personal,id_labor,valor_individual,cantidad,valor_total,fecha_realizacion) VALUEs ('$idPersonal','$idLabor','$valorIndividual','$cantidad','$valorTotal','$fecha')");
        if($relacionarLaborPersonal->execute()){
            echo "<script>location.href='laboresPersonalGestion.php';</script>";
        }

    }

    //Traer personal 
    $traerPersonal = $connect->prepare("SELECT * FROM personal");
    if($traerPersonal->execute()) {
        $personal = $traerPersonal->fetchAll(PDO::FETCH_ASSOC);
    }

    //Traer labores
    $traerLabores = $connect->prepare("SELECT * FROM labores");
    if($traerLabores->execute()) {
        $labores = $traerLabores->fetchAll(PDO::FETCH_ASSOC);
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
        <link rel="icon" type="image/x-icon" href="assets/img/AGRICONTROL.ico"/>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!--<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">-->
        <!-- Bs icons -->
        <!-- <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <!-- Select2 Bower -->
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
                        <li><a class="dropdown-item text-light fs-6 me-3" href="laboresPersonalGestion.php"><i class="bi bi-arrow-left-square-fill fs-5"></i> Atras</a></li>
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
            <p class="text-white fw-bold fs-6 p-3">Registrar labor - personal</p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-xl-10">
                    <div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg p-3 rounded-3 opacity9">
                        <!-- div class="p-6 bg-white border-b border-gray-200" -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4" style="overflow:hidden">
                                    <label for="" class="form-label text-white">Seleccionar personal</label>
                                    <select class="form-select" aria-label="Default select example" id="seleccionarPersonal" name="personal">
                                        <option selected disabled>Seleccione un personal</option>
                                        <?php
                                            foreach ($personal as $ps) {
                                                echo "<option value=".$ps['id'].">".$ps['nombre']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                                    <label for="" class="form-label text-white">Identificación</label>
                                    <input type="text" name="identificacion" id="identificacion" class="form-control" value="" placeholder="Identificación" readonly>
                                </div>
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                                <label for="" class="form-label text-white">Cargo</label>
                                    <input type="text" name="cargo" id="cargo" class="form-control" value="" placeholder="Cargo" readonly>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12 col-xl-12">
                                    <hr class="bg-success" style="width: 100%; height: 4px; opacity: 1;">
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center mt-3">
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                                    <label for="" class="form-label text-white">Seleccionar labor</label>
                                    <select class="form-select" aria-label="Default select example" id="seleccionarLabor" name="labor">
                                        <option selected disabled>Seleccione una labor</option>
                                        <?php
                                            foreach ($labores as $lb) {
                                                echo "<option value=".$lb['id'].">".$lb['nombre_labor']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                                    <label for="" class="form-label text-white">Unidad de medida</label>
                                    <input type="text" name="unidad_medida" id="unidad_medida" class="form-control" value="" placeholder="Unidad de medida" readonly>
                                </div>
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                                    <label for="" class="form-label text-white">Valor individual</label>
                                    <input type="text" name="valor_labor" id="valor_labor" class="form-control" value="" placeholder="Valor de labor individual" readonly>
                                    <input type="hidden" name="valor_laborOculto" id="valor_laborOculto" class="form-control" value="" readonly>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12 col-xl-12">
                                    <hr class="bg-success" style="width: 100%; height: 4px; opacity: 1;">
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center mt-3">
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                                    <label for="" class="form-label text-white">Seleccionar fecha</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control">
                                </div>
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                                    <label for="" class="form-label text-white">Cantidad</label>
                                    <input type="text" name="cantidadActividades" id="cantidadActividades" class="form-control" value="" placeholder="Cantidad">
                                </div>
                                <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                                    <label for="" class="form-label text-white">Valor total</label>
                                    <input type="text" name="" id="valorTotal" class="form-control" value="" placeholder="Valor total" readonly>
                                    <input type="hidden" name="valorTotalOculto" id="valorTotalOculto">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12 col-xl-12">
                                    <hr class="bg-success" style="width: 100%; height: 4px; opacity: 1;">
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center mb-2">
                                <div class="col-12 col-xl-4">
                                    <input class="btn btn-success btn-submit form-control" name="guardarLaborPersonal" type="submit" value="Guardar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- Sweet alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Numeros a letras -->
        <script src="js/numeroALetras.js"></script>
        <!-- Main js -->
        <script type="text/javascript">

            window.addEventListener("load", function(event) {

                function financial(x) {
                    return Number.parseFloat(x).toFixed(2);
                }

                //Instanciar formateador de numeros
                const formatterPeso = new Intl.NumberFormat('es-CO',
                {
                    style: 'currency',
                    currency: 'COP',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 1
                });

                //Funciónn para formatear valores
                function formatear_valores_pesos (valor)
                {
                    return formatterPeso.format(valor);
                }

                //Activar select2
                $("#seleccionarPersonal").select2()
                $("#seleccionarLabor").select2()

                //Capturar select personal
                var seleccionarPersonal = document.getElementById("seleccionarPersonal");

                //Detectar cuando cambia personal 
                $("#seleccionarPersonal").change( ()=>{
                    $.ajax({
                        url: 'assets/ajax/traerDatosPersonal.php',
                        type: 'POST',
                        dataType: 'json',
                        data: "idPersonal=" + $("#seleccionarPersonal").val(),
                    })
                    .done(function(res) {
                        //console.log(res) 
                        $("#identificacion").val(res.identificacion)
                        $("#cargo").val(res.nombrecargo)
                    })
                    .fail(function() {
                        console.log('Fallo')
                    })
                    .always(function() {
                        
                    });
                })
                
                //Capturar select labor
                var seleccionarLabor = document.getElementById("seleccionarLabor");
                //Detectar cuando cambia personal 
                $("#seleccionarLabor").change( ()=>{
                    $.ajax({
                        url: 'assets/ajax/traerDatosLabor.php',
                        type: 'POST',
                        dataType: 'json',
                        data: "idLabor=" + $("#seleccionarLabor").val(),
                    })
                    .done(function(res) {
                        //console.log(res) 
                        $("#unidad_medida").val(res.unidad_medida)
                        $("#valor_labor").val(formatear_valores_pesos(res.precio_labor))
                        $("#valor_laborOculto").val(res.precio_labor)
                    })
                    .fail(function() {
                        console.log('Fallo')
                    })
                    .always(function() {
                        
                    });
                })


                //Capturar elemento 
                var cantidad = document.getElementById("cantidadActividades");
                //Agregar evento listener 
                cantidad.addEventListener("input", ()=>{
                    //Capturar cantidad 
                    var cantidad = Number($("#cantidadActividades").val())
                    //Capturar valor de valor labor
                    var valorConSigno = $("#valor_labor").val()
                    //Quitar signo 
                    var valorSinSigno = Number(valorConSigno.replace(/[^0-9]+/g, ""))
                    var valorSinDecimales = financial(valorSinSigno)
                    //Calcular total
                    var total = cantidad * valorSinSigno

                    /*console.log(cantidad)
                    console.log(valorSinSigno)
                    console.log(valorSinDecimales)*/
                    
                    //Poner valor total en su input
                    $("#valorTotalOculto").val(total)
                    //Valor formateado
                    var valorTotalFormateado = formatear_valores_pesos(total)
                    //Poner valor en el input visible para el cliente
                    $("#valorTotal").val(valorTotalFormateado)
                });
                

            });
            
        </script>        
    </body>
</html>
