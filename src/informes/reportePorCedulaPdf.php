<?php

    //Iniciar objeto 
    ob_start();

    //Cargar clases
    require '../../vendor/autoload.php';
    //Usar clases 
    use Dompdf\Dompdf;
    use Dompdf\Options;

    //Inicio de sesión
    session_start();

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

    //Capturar cedula
    $cedula = $_GET['cedula'];

    //Instanciar formateador de numeros 
    $fmt = new \NumberFormatter('es_CO', \NumberFormatter::CURRENCY);

    //Traer datos
    $traerLaboresPersonal = $connect->prepare("SELECT pl.id, ps.nombre as nombrePersonal, lb.nombre_labor as nombreLabor, pl.cantidad, pl.valor_total, pl.fecha_realizacion as fecha, lb.unidad_medida, pl.valor_individual, pl.lote FROM personal_labores pl INNER JOIN personal ps ON pl.id_personal = ps.id INNER JOIN labores lb ON pl.id_labor = lb.id WHERE ps.identificacion = '$cedula'");
    if($traerLaboresPersonal->execute()){
        $laboresPersonal = $traerLaboresPersonal->fetchAll(PDO::FETCH_ASSOC);
    }

    //Declarar variable 
    $salarioLabores = 0;
    foreach ($laboresPersonal as $suma) {
        //Calcular suma
        $salarioLabores = $salarioLabores + $suma['valor_total'];
    }

    //Definir valor
    $salarioLabores = $fmt->formatCurrency($salarioLabores, 'COP');

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
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="../assets/img/AGRICONTROL.ico"/>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- Bs icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <style>
            table {
            width: 100%;
            border: 1px solid #000;
            }

            th, td {
            width: 25%;
            text-align: left;
            vertical-align: top;
            border: 1px solid #000;
            border-collapse: collapse;
            }
        </style>
    </head>
    <body class="">
        <div class="container">
            <div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg opacity9">         
                <div class="row justify-content-center align-items-center mt-3 mb-2">
                    <div class="col-10 col-sm-10 col-md-10 col-lg-4 col-xl-3 text-center">
                        <label for="" class="form label text-white">VALOR TOTAL LABORES REALIZADAS</label>
                    </div>
                    <div class="col-10 col-sm-10 col-md-10 col-lg-4 col-xl-3 text-center">
                        <?php
                            
                            switch ($permisos) {
                                case '1':
                                    echo '
                                    <input type="text" placeholder="Salario en labores" class="form-control" value="'.$salarioLabores.'" readonly>                                  
                                    ';
                                    break;
                                case '2':
                                    echo '
                                    <input type="text" placeholder="Salario en labores" class="form-control" value="" readonly>                                  
                                    ';
                                    break;
                                case '3':
                                    echo '
                                    <input type="text" placeholder="Salario en labores" class="form-control" value="'.$salarioLabores.'" readonly>                           
                                    ';
                                    break;
                                default:
                                    # code...
                                    break;
                            }

                        ?>

                    </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="table-responsive p-2">
                            <table class="table table-dark table-striped table-bordered mb-2" id="tablaPersonal" style="width: 100%">
                                <thead>
                                    <tr class="text-center">
                                        <?php
                                        
                                        switch ($permisos) {
                                            case '1':
                                                echo '
                                                <th>Nombre personal</th>
                                                <th>Actividad</th>
                                                <th>Lote</th>
                                                <th>U.medida</th>
                                                <th>Cantidad</th>
                                                <th>Valor Individual</th>
                                                <th>Valor total</th>
                                                <th>Fecha realización</th>
                                                ';
                                                break;
                                            case '2':
                                                echo '
                                                <th>Nombre personal</th>
                                                <th>Actividad</th>
                                                <th>Lote</th>
                                                <th>U.medida</th>
                                                <th>Cantidad</th>
                                                <th>Fecha realización</th>
                                                ';
                                                break;
                                            case '3':
                                                echo '
                                                <th>Nombre personal</th>
                                                <th>Actividad</th>
                                                <th>Lote</th>
                                                <th>U.medida</th>
                                                <th>Cantidad</th>
                                                <th>Valor Individual</th>
                                                <th>Valor total</th>
                                                <th>Fecha realización</th>
                                                ';
                                                break;
                                            default:
                                                # code...
                                                break;
                                        }
                                        ?>
                                        
                                    </tr>
                                </thead>
                                <tbody style="text-center">
                                    <?php 

                                    //Administrador
                                    if($permisos == '1'){
                                        foreach ($laboresPersonal as $lb) {
                                            echo "<tr class='text-center' style='text-center'>
                                                <td style='text-center'>".$lb['nombrePersonal']."</td>
                                                <td style='text-center'>".$lb['nombreLabor']."</td>
                                                <td style='text-center'>".$lb['lote']."</td>
                                                <td style='text-center'>".$lb['unidad_medida']."</td>
                                                <td style='text-center'>".$lb['cantidad']."</td>
                                                <td style='text-center'>".$fmt->formatCurrency($lb['valor_individual'], 'COP')."</td>
                                                <td style='text-center'>".$fmt->formatCurrency($lb['valor_total'], 'COP')."</td>
                                                <td style='text-center'>".$lb['fecha']."</td>
                                            </tr>";
                                        }
                                    }

                                    //Coordinador
                                    if($permisos == '2'){
                                        foreach ($laboresPersonal as $lb) {
                                            echo "<tr class='text-center' style='text-center'>
                                            <td style='text-center'>".$lb['nombrePersonal']."</td>
                                            <td style='text-center'>".$lb['nombreLabor']."</td>
                                            <td style='text-center'>".$lb['lote']."</td>
                                            <td style='text-center'>".$lb['unidad_medida']."</td>
                                            <td style='text-center'>".$lb['cantidad']."</td>
                                            <td style='text-center'>".$lb['fecha']."</td>
                                        </tr>";
                                        }
                                    }

                                    //Auditor
                                    if($permisos == '3'){
                                        foreach ($laboresPersonal as $lb) {
                                            echo "<tr class='text-center' style='text-center'>
                                                <td style='text-center'>".$lb['nombrePersonal']."</td>
                                                <td style='text-center'>".$lb['nombreLabor']."</td>
                                                <td style='text-center'>".$lb['lote']."</td>
                                                <td style='text-center'>".$lb['unidad_medida']."</td>
                                                <td style='text-center'>".$lb['cantidad']."</td>
                                                <td style='text-center'>".$fmt->formatCurrency($lb['valor_individual'], 'COP')."</td>
                                                <td style='text-center'>".$fmt->formatCurrency($lb['valor_total'], 'COP')."</td>
                                                <td style='text-center'>".$lb['fecha']."</td>
                                            </tr>";
                                        }
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
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
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
<?php
//Finalizar objeto
$html = ob_get_clean();

///Fijar opciones 
$options = new Options();
$options->set('defaultFont', 'Courier');
$dompdf = new Dompdf($options);
// instantiate and use the dompdf class
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
//echo $html;
?>
