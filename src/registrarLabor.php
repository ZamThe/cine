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

    //print_r($tiposContrato);

    //Detectar envio de fomulario 
    if(isset($_POST['guardarLabor'])){

        //Capturar los datos enviados por el formulario
        $codigo_labor = $_POST['codigo_labor'];
        $nombre_valor = $_POST['nombre_labor'];
        $unidad_medida = $_POST['unidad_medida'];
        $precio_labor = $_POST['precio_labor'];

        //Guardar registro
        $guardarLabor = $connect->prepare("INSERT INTO labores (codigo_labor,nombre_labor,unidad_medida,precio_labor) VALUES ('$codigo_labor','$nombre_valor','$unidad_medida','$precio_labor')");
        if($guardarLabor->execute()){
            echo "<script>location.href='laboresGestion.php';</script>";
        }
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
        <!-- Bootstrap NPM -->
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <!-- Bs icons -->
        <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
        <!-- Select2 Bower -->
        <link href="../bower_components/select2/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Sweet alert2 -->
        <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.css">
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
                        <li><a class="dropdown-item text-light fs-6 me-3" href="laboresGestion.php"><i class="bi bi-arrow-left-square-fill fs-5"></i> Atras</a></li>
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
            <p class="text-white fw-bold fs-6 p-3">Registrar labor</p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10 col-xl-6">
                    <div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg p-2 rounded-3 opacity9">
                        <!-- div class="p-6 bg-white border-b border-gray-200" -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-center p-2">
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="codigo_labor" class="form-label text-white">Código <b class="text-danger">*</b></label>
                                        <input id="codigo_labor" name="codigo_labor" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="nombre_labor" class="form-label text-white">Nombre <b class="text-danger">*</b></label>
                                        <input id="nombre_labor" name="nombre_labor" type="text" class="form-control" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center p-2">
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="unidad_medida" class="form-label text-white">Unidad de medida <b class="text-danger">*</b></label>
                                        <input id="unidad_medida" name="unidad_medida" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-10 col-xl-6 p-2">
                                    <label for="precio_labor" class="form-label text-white">Salario <b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <label for="" class="input-group-text" id="verPrecioLetras">$</label>
                                        <input id="precio_labor" name="precio_labor" type="text" class="form-control numeric" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12 col-xl-12">
                                    <hr class="bg-success" style="width: 100%; height: 4px; opacity: 1;">
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center mb-2">
                                <div class="col-12 col-xl-4">
                                    <input class="btn btn-success btn-submit form-control" name="guardarLabor" type="submit" value="Guardar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jquery Bower -->
       <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Select2 bower -->
        <script src="../bower_components/select2/dist/js/select2.min.js"></script>        
        <!-- JavaScript Bundle with Popper -->
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/js/bootstrap.min.js">
        <!-- Sweet alert -->
        <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <!-- Numeros a letras -->
        <script src="js/numeroALetras.js"></script>
        <!-- Main js -->
        <script type="text/javascript">

            window.addEventListener("load", function(event) {

                //Instanciar formateador de numeros
                const formatterPeso = new Intl.NumberFormat('es-CO',
                {
                    style: 'currency',
                    currency: 'COP',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                //Funciónn para formatear valores
                function formatear_valores_pesos (valor)
                {
                    return formatterPeso.format(valor);
                }

                //Capturar valor de salario 
                var precioFormateado = document.getElementById('precio_labor');

                //Permitir solo numeros en un input 
                $("#precio_labor").numeric();
                var verPrecioLetras = document.getElementById("verPrecioLetras")
                verPrecioLetras.addEventListener('click', ()=>{
                    Swal.fire({
                        //icon: 'error',
                        title: 'Valor en letras',
                        text: NumeroALetras(precioFormateado.value)
                    })
                    //alert('Valor de: '+NumeroALetras(salarioFormateado.value))
                })
            });
            
        </script>        
    </body>
</html>
