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

    //Traer los tipos de identificacion
    $traerTiposIdentificacion = $connect->prepare("SELECT * FROM tipos_identificacion");
    if($traerTiposIdentificacion->execute()) {
        $tiposIdentificacion = $traerTiposIdentificacion->fetchAll(PDO::FETCH_ASSOC);
    }

    //Traer todos los tipos de cargo
    $traerTiposCargo = $connect->prepare("SELECT * FROM cargos");
    if($traerTiposCargo->execute()) {
        $tiposCargo = $traerTiposCargo->fetchAll(PDO::FETCH_ASSOC);
    }

    //Detectar envio de fomulario 
    if(isset($_POST['guardarPersonal'])){

        //Capturar los datos enviados por el formulario
        $nombre = $_POST['nombre'];
        $tipoIdentificacion = $_POST['idTipoIdentificacion'];
        $identificacion = $_POST['identificacion'];
        $idCargo = $_POST['cargo'];
        $fechaIngreso = $_POST['fechaIngreso'];
        $tallaBuso = $_POST['tallaBuso'];
        $tallaPantalon = $_POST['tallaPantalon'];
        $tallaBotas = $_POST['tallaBotas'];

        //Guardar registro
        $guardarPersonal = $connect->prepare("INSERT INTO personal (nombre,id_tipo_identificacion,identificacion,id_cargo,fecha_ingreso,talla_buso,talla_pantalon,talla_botas) VALUES ('$nombre','$tipoIdentificacion','$identificacion','$idCargo','$fechaIngreso','$tallaBuso','$tallaPantalon','$tallaBotas')");
        if($guardarPersonal->execute()){
            echo "<script>location.href='personalGestion.php';</script>";
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
                        <li><a class="dropdown-item text-light fs-6" href="personalGestion.php"><i class="bi bi-arrow-left-square-fill fs-5"></i> Atras</a></li>
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
            <p class="text-white fw-bold fs-6 p-3">Registrar personal</p>
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
                                        <label for="nombre" class="form-label text-white">Nombre <b class="text-danger">*</b></label>
                                        <input id="nombre" name="nombre" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="idTipoIdentificacion" class="form-label text-white">Tipo identificación <b class="text-danger">*</b></label>
                                        <select id="idTipoIdentificacion" name="idTipoIdentificacion" class="form-select" required>
                                            <option value="" selected disabled>Seleccione un tipo de identificación</option>
                                            <?php
                                            foreach ($tiposIdentificacion as $tipoIde) {
                                                echo '<option value="'.$tipoIde['id'].'">'.$tipoIde['nombreTipoIdentificacion'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center p-2">
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="identificacion" class="form-label text-white">Identificacion <b class="text-danger">*</b></label>
                                        <input id="identificacion" name="identificacion" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="cargo" class="form-label text-white">Cargo <b class="text-danger">*</b></label>
                                        <select id="cargo" name="cargo" class="form-select" required>
                                            <option value="" selected disabled>Seleccione un cargo</option>
                                            <?php
                                            foreach ($tiposCargo as $tipoCargo) {
                                                echo '<option value="'.$tipoCargo['id'].'">'.$tipoCargo['nombre_cargo'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center p-2">
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="fechaIngreso" class="form-label text-white">Fecha de ingreso <b class="text-danger">*</b></label>
                                        <input id="fechaIngreso" name="fechaIngreso" type="date" placeholder="(C.C., NIT, etc.) sin puntos, guiones ni dígito de verificación" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="tallaBuso" class="form-label text-white">Talla buso <b class="text-danger">*</b></label>
                                        <input id="tallaBuso" name="tallaBuso" type="text" class="form-control" required/>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row justify-content-start p-2">
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="tallaBotas" class="form-label text-white">Talla botas <b class="text-danger">*</b></label>
                                        <input id="tallaBotas" name="tallaBotas" type="text" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="tallaPantalon" class="form-label text-white">Talla pantalón <b class="text-danger">*</b></label>
                                        <input id="tallaPantalon" name="tallaPantalon" type="text" class="form-control"/>
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
                                    <input class="btn btn-success btn-submit form-control" name="guardarPersonal" type="submit" value="Guardar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">

        </script>        
    </body>
</html>
