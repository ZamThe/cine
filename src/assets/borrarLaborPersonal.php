<?php

    header("Content-Type: text/html;charset=utf-8");

    require '../database/database.php';

    //Establecer zona horario y variables de hora/fecha actual
    date_default_timezone_set('America/Bogota');
    $fechaActual = date("y-m-d");
    $horaActual = date("H:i:s", time()); 

    //Capturar id del personal 
    $idLaborPersonal = $_GET['idLaborPersonal'];

    //Borar Personal 
    $borrarLaborPersonal = $connect->prepare("DELETE FROM personal_labores WHERE id = '$idLaborPersonal'");
    if($borrarLaborPersonal->execute()){
        echo '<script>location.href="../laboresPersonalGestion.php"</script>';
    }else{
        echo '<script>location.href="../laboresPersonalGestion.php"</script>';
    }

?>