<?php

    header("Content-Type: text/html;charset=utf-8");

    require '../database/database.php';

    //Establecer zona horario y variables de hora/fecha actual
    date_default_timezone_set('America/Bogota');
    $fechaActual = date("y-m-d");
    $horaActual = date("H:i:s", time()); 

    //Capturar id del personal 
    $idPersonal = $_GET['idPersonal'];

    //Borar Personal 
    $borrarPersonal = $connect->prepare("DELETE FROM personal WHERE id = '$idPersonal'");
    if($borrarPersonal->execute()){
        echo '<script>location.href="../personalGestion.php"</script>';
    }

?>