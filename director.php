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

// Ejemplo de uso:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_director = $_POST["id_director"];
    $nombre = $_POST["nombre"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $descripcion = $_POST["descripcion"];

    // Llama a la función para crear un nuevo director
    crearDirector($id_director, $nombre, $fecha_nacimiento, $descripcion);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario para Crear Director</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
  

    <div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
        <h2>El señor de las PELICULAS</h2>
    </div>
<ul class="menu">
    <li><a href="index.php">Inicio</a></li>
    <li><a href="crear.php">Crear productora</a></li>
    <li class="submenu">
        <a href="director.php">Crear   Directores</a>
        <ul class="sub-menu">
            <li><a href="eliminar.php">Eliminar opción 1</a></li>
            <li><a href="eliminar.php">Eliminar opción 2</a></li>
        </ul>
    </li>
    <li class="submenu">
        <a href="#">Ver</a>
        <ul class="sub-menu">
            <li><a href="ver.php">Ver opción 1</a></li>
            <li><a href="ver.php">Ver opción 2</a></li>
        </ul>
    </li>
</ul>
<h2>Crear Director</h2>
<br>
    <form method="post" action="">
        <label for="id_director">ID del Director:</label>
        <input type="text" name="id_director" required><br>

        <label for="nombre">Nombre del Director:</label>
        <input type="text" name="nombre" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea><br>

        <input type="submit" name="submit" value="Guardar">
    </form>
</body>
</html>
