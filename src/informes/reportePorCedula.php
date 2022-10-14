<?php

    //** HEADER BACKEND
    session_start();

    require '../database/database.php';
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

    //Instanciar formateador de numeros 
    $fmt = new \NumberFormatter('es_CO', \NumberFormatter::CURRENCY);

    if(isset($_POST['reportePorSoloCedula'])){
        //Capturar cedula
        $cedula = $_POST['cedula'];
        //Traer datos
        $traerLaboresPersonal = $connect->prepare("SELECT pl.id, ps.nombre as nombrePersonal, lb.nombre_labor as nombreLabor, pl.cantidad, pl.valor_total, pl.fecha_realizacion as fecha FROM personal_labores pl INNER JOIN personal ps ON pl.id_personal = ps.id INNER JOIN labores lb ON pl.id_labor = lb.id WHERE ps.identificacion = '$cedula'");
        if($traerLaboresPersonal->execute()){
            $laboresPersonal = $traerLaboresPersonal->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //Declarar variable 
    $salarioLabores = 0;
    foreach ($laboresPersonal as $suma) {
        //Calcular suma
        $salarioLabores = $salarioLabores + $suma['valor_total'];
    }

    //Definir valor
    $salarioLabores = $fmt->formatCurrency($salarioLabores, 'COP')

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
        <!-- Bs icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <!-- Select2 -->
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
                        <li><a class="dropdown-item text-light fs-6 me-3" href="../laboresPersonalDetalle.php"><i class="bi bi-arrow-left-square-fill fs-5"></i> Atras</a></li>
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
            <p class="text-white fw-bold fs-6 p-3">Reporte por cedula</p>
        </div>
        <div class="container">
            <div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg opacity9">         
                <div class="row justify-content-center align-items-center mt-3 mb-2">
                    <div class="col-10 col-sm-10 col-md-10 col-lg-4 col-xl-3 text-center">
                        <label for="" class="form label text-white">VALOR TOTAL LABORES REALIZADAS</label>
                    </div>
                    <div class="col-10 col-sm-10 col-md-10 col-lg-4 col-xl-3 text-center">
                        <input type="text" placeholder="Salario en labores" class="form-control" value="<?php echo $salarioLabores; ?>" readonly>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="table-responsive p-2">
                            <table class="table table-dark table-striped table-bordered mb-2" id="tablaPersonal" style="width: 100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nombre personal</th>
                                        <th>Actividad</th>
                                        <th>Cantidad</th>
                                        <th>Valor total</th>
                                        <th>Fecha realización</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($laboresPersonal as $lb) {
                                            echo "<tr class='text-center'>
                                                <td>".$lb['nombrePersonal']."</td>
                                                <td>".$lb['nombreLabor']."</td>
                                                <td>".$lb['cantidad']."</td>
                                                <td>".$fmt->formatCurrency($lb['valor_total'], 'COP')."</td>
                                                <td>".$lb['fecha']."</td>
                                            </tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
        <script src="../js/numeroALetras.js"></script>
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

            });


        </script>
    </body>
</html>

