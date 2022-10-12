<?php

require '../../database/database.php';

//Traer los datos de un usuario 
if(isset($_POST['idPersonal'])) {
    //Capturar idPersonal
    $idPersonal = $_POST['idPersonal'];
    //Capturar datos del personal
    $traerDatosPersonal = $connect->prepare("SELECT ps.id,ps.nombre,ps.id_cargo,ps.identificacion,cs.nombre_cargo as nombrecargo FROM personal ps INNER JOIN cargos cs ON ps.id_cargo = cs.id WHERE ps.id = '$idPersonal'");
    if($traerDatosPersonal->execute()){
        $datosPersonal = $traerDatosPersonal->fetch(PDO::FETCH_ASSOC);
    }

    echo json_encode($datosPersonal);
}

?>