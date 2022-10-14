<?php

    //** HEADER BACKEND
    session_start();

    header("Content-Type: text/html;charset=utf-8");

    require '../database/database.php';

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

    //Capture number of authorization
    $idLabor = $_GET['idLabor'];
    //Capturar datos de la labor 
    $traerDatosLabor = $connect->prepare("SELECT * FROM labores WHERE id = '$idLabor'");
    if($traerDatosLabor->execute()){
        $datosLabor = $traerDatosLabor->fetch(PDO::FETCH_ASSOC);
    }

    //Detectar si el usuario quiere cambiar los datos del usuario 
    if(isset($_POST['actualizarLabor'])){

        //Capturar los datos enviados por el formulario
        $nombre_labor = $_POST['nombre_labor'];
        $unidad_medida = $_POST['unidad_medida'];
        $precio_labor = $_POST['precio_labor'];

        /*//Debug values 
        echo 'Nombre: '.$nombre.'<br>';
        echo 'TipoIdentificación: '.$tipoIdentificacion.'<br>';
        echo 'Identificación: '.$identificacion.'<br>';
        echo 'IdCargo: '.$idCargo.'<br>';
        echo 'fechaIngreso: '.$fechaIngreso.'<br>';
        echo 'idTipoContrato: '.$idTipoContrato.'<br>';
        echo 'salario: '.$salario.'<br>';
        echo 'tallBuso: '.$tallaBuso.'<br>';
        echo 'tallaPantalon: '.$tallaPantalon.'<br>';
        echo 'tallaBotas: '.$tallaBotas.'<br>';*/

        //(nombre,id_tipo_identificacion,identificacion,id_cargo,fecha_ingreso,id_tipo_contrato,salario,talla_buso,talla_pantalon,talla_botas) 


        //Actualizar labor
        $actualizarLabor = $connect->prepare("UPDATE labores SET nombre_labor = '$nombre_labor', unidad_medida = '$unidad_medida', precio_labor = '$precio_labor' WHERE id = '$idLabor'");
        if($actualizarLabor->execute()){
            echo '<script>location.href="../laboresGestion.php"</script>';
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
        <link rel="icon" type="image/x-icon" href="assets/img/AGRICONTROL.ico"/>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!--<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">-->
        <!-- Bs icons -->
        <!-- <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <!-- Select2 Bower -->
        <!-- <link href="../bower_components/select2/dist/css/select2.min.css" rel="stylesheet" /> -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Main css -->
        <link rel="stylesheet" href="../css/styles.css">
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
                        <li><a class="dropdown-item text-light fs-6 me-3" href="../laboresGestion.php"><i class="bi bi-arrow-left-square-fill fs-5"></i> Atras</a></li>
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
            <p class="text-white fw-bold fs-6 p-3">Editar labor</p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10 col-xl-6">
                    <div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg p-2 rounded-3 opacity9">
                        <!-- div class="p-6 bg-white border-b border-gray-200" -->
                        <form action="" method="post" enctype="multipart/form-data">
                        <div class="row justify-content-center p-2">
                                <!--<div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="codigo_labor" class="form-label text-white">Código <b class="text-danger">*</b></label>
                                        <input id="codigo_labor" name="codigo_labor" type="text" class="form-control" required/>
                                    </div>
                                </div>-->
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="nombre_labor" class="form-label text-white">Nombre <b class="text-danger">*</b></label>
                                        <input id="nombre_labor" name="nombre_labor" type="text" class="form-control" placeholder="Nombre de la labor" value="<?php echo $datosLabor['nombre_labor'] ?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center p-2">
                                <div class="col-10 col-xl-6 p-2">
                                    <div class="form-group">
                                        <label for="unidad_medida" class="form-label text-white">Unidad de medida <b class="text-danger">*</b></label>
                                        <input id="unidad_medida" name="unidad_medida" type="text" class="form-control" placeholder="Unidad de medida" value="<?php echo $datosLabor['unidad_medida'] ?>" required/>
                                    </div>
                                </div>
                                <div class="col-10 col-xl-6 p-2">
                                    <label for="precio_labor" class="form-label text-white">Precio labor <b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <label for="" class="input-group-text" id="verPrecioLetras">$</label>
                                        <input id="precio_labor" name="precio_labor" type="text" class="form-control numeric" placeholder="Precio valor individual" value="<?php echo $datosLabor['precio_labor'] ?>" required/>
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
                                    <input class="btn btn-success btn-submit form-control" name="actualizarLabor" type="submit" value="Guardar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jquery Bower -->
        <!-- <script src="../bower_components/jquery/dist/jquery.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <!-- Select2 bower -->
        <!-- <script src="../bower_components/select2/dist/js/select2.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <!--<link rel="stylesheet" href="../node_modules/bootstrap/dist/js/bootstrap.min.js">-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- Sweet alert -->
        <!--<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>-->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Jquery numeric -->
        <script src="https://cdn.jsdelivr.net/npm/jquery.numeric@1.0.0/jquery.numeric.min.js"></script>
        <!-- Numeros a letras -->
        <script src="../js/numeroALetras.js"></script>
        <!-- Script --> 
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
                var salarioFormateado = document.getElementById('salarioFormateado');

                //Permitir solo numeros en un input 
                $("#salarioFormateado").numeric();
            });
            
        </script>        
    </body>
</html>