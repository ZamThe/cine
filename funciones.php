<?php
// Función para crear un nuevo director
function crearDirector($id_director, $nombre, $fecha_nacimiento, $descripcion) {
    // Establece la conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "cine");

    // Verifica si hay errores de conexión
    if ($conexion->connect_error) {
        die("Error de conexión a la base de datos: " . $conexion->connect_error);
    }

    // Escapar las entradas del usuario para evitar SQL Injection
    $id_director = $conexion->real_escape_string($id_director);
    $nombre = $conexion->real_escape_string($nombre);
    $fecha_nacimiento = $conexion->real_escape_string($fecha_nacimiento);
    $descripcion = $conexion->real_escape_string($descripcion);

    // Consulta SQL para insertar un nuevo director
    $insercion = "INSERT INTO director (id_director, Nombre_director, Fecha_nacimiento, descripcion) VALUES ('$id_director', '$nombre', '$fecha_nacimiento', '$descripcion')";
    
    if ($conexion->query($insercion) === TRUE) {
        echo "Director creado correctamente.";
    } else {
        echo "Error al crear el director: " . $conexion->error;
    }

    // Cierra la conexión a la base de datos
    $conexion->close();
}
?>
