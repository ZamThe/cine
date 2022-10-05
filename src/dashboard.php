<?php

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
    $traerDatosUsuario = $connect->prepare("SELECT * from users WHERE id = '$idUsuario'");
    if($traerDatosUsuario->execute()){
        $usuario = $traerDatosUsuario->fetch();
    }

    print_r($usuario);

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
        <nav class="navbar navbar-expand-lg bg-light navbar-light border-bottom border-4 border-white w-100">
            <div class="container p-2">
                <a class="navbar-brand fs-6 text-dark" href="homeUser.php"> <i class="bi bi-house-door-fill fs-5"></i> Inicio </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list text-secondary fs-5"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <!--<li><a class="dropdown-item text-secondary fs-6" href="homeAdmin.php"><i class="bi bi-arrow-left-square-fill fs-5"></i> Atras</a></li>-->
                        <li><a class="dropdown-item text-dark fs-6" href="#"><i class="bi bi-person-circle fs-5"></i> <?php echo ' '.$usuario['name']; ?> </a></li>
                        <li><a class="dropdown-item text-dark fs-6" href="logout.php"><i class="bi bi-door-open-fill fs-5"></i> Salir</a></li>
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
            <p class="text-white fw-bold fs-6 p-3">Modulos <?php echo ' '.$usuario['name'];?> </p>
        </div>
        <div class="container p-2 mt-5 rounded-3 opacity9" style="padding-right: 0px;padding-left:0px;overflow:hidden;">
            <div class="row text-center justify-content-around" style="padding-right: 0px;padding-left:0px;">
                <?php
                switch ($permisos) {
                    case '1':
                        echo '
                        <div class="col-10 col-sm-10 col-md-6 col-lg-3 col-xl-3 mt-1">
                            <a href="programarAutorizacion.php" class="text-white btn bg-success bg-gradient p-4 mt-2 mb-2 fw-bold main-buttons" style="text-decoration:none;width: 100%;border-radius: 10px;border: 2px solid">
                                Personal
                            </a>
                        </div>
                        <div class="col-10 col-sm-10 col-md-6 col-lg-3 col-xl-3 mt-1">
                            <a href="programarAutorizacion.php" class="text-white btn bg-success bg-gradient p-4 mt-2 mb-2 fw-bold main-buttons" style="text-decoration:none;width: 100%;border-radius: 10px;border: 2px solid">
                                Labores/actividades
                            </a>
                        </div>
                        <div class="col-10 col-sm-10 col-md-6 col-lg-3 col-xl-3 mt-1">
                            <a href="programarAutorizacion.php" class="text-white btn bg-success bg-gradient p-4 mt-2 mb-2 fw-bold main-buttons" style="text-decoration:none;width: 100%;border-radius: 10px;border: 2px solid">
                                Administrar 
                            </a>
                        </div>
                        <div class="col-10 col-sm-10 col-md-6 col-lg-3 col-xl-3 mt-1">
                            <a href="programarAutorizacion.php" class="text-white btn bg-success bg-gradient p-4 mt-2 mb-2 fw-bold main-buttons" style="text-decoration:none;width: 100%;border-radius: 10px;border: 2px solid">
                                Radicación
                            </a>
                        </div>
                        ';
                        break;
                    case '2':
                        echo '
                        <div class="col-lg-4 col-md-8 col-12 col-xl-4 mt-1" id="programAutho" data-aos="zoom-in" data-aos-duration="2000" data-aos-offset="0">
                            <a href="programarAutorizacion.php" class="text-white btn btn-primary p-3 main-buttons" style="text-decoration:none;width: 100%;border-radius: 10px;border: 1px solid">
                                Radicación
                            </a>
                        </div>
                        ';
                        break;
                    case '3':
                        # code...
                        break;
                    case '4':
                        # code...
                        break;
                    default:
                        # code...
                        break;
                }
                ?>
            </div>
        </div>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
           
        </script>
    </body>
</html>