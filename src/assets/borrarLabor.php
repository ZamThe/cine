<?php

    header("Content-Type: text/html;charset=utf-8");

    require '../database/database.php';

    //Establecer zona horario y variables de hora/fecha actual
    date_default_timezone_set('America/Bogota');
    $fechaActual = date("y-m-d");
    $horaActual = date("H:i:s", time()); 

    //Capturar id del personal 
    $idLabor = $_GET['idLabor'];

    //Borar Personal 
    $borrarLabor = $connect->prepare("DELETE FROM labores WHERE id = '$idLabor'");
    if($borrarLabor->execute()){
        echo '<script>location.href="../laboresGestion.php"</script>';
    }else{
        echo '<script>location.href="../laboresGestion.php"</script>';
    }

?>