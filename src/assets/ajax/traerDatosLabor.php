<?php

require '../../database/database.php';

//Traer los datos de un usuario 
if(isset($_POST['idLabor'])) {
    //Capturar idPersonal
    $idLabor = $_POST['idLabor'];
    //Capturar datos del personal
    $traerDatosLabor = $connect->prepare("SELECT * FROM labores WHERE id = '$idLabor'");
    if($traerDatosLabor->execute()){
        $datosLabor = $traerDatosLabor->fetch(PDO::FETCH_ASSOC);
    }

    echo json_encode($datosLabor);
}

?>