<html>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/styles.css">
<style>
/* Estilo para el título */



</style>
<head>
    <meta charset="UTF-8">
    <title>Crear Película</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Enlaza tu archivo CSS externo aquí -->
</head>

<?php
include 'conexion.php';
// Operación CREATE (Crear una nueva película)
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $genero = $_POST['genero'];
    $descripcion = $_POST['descripcion'];
    $duracion = $_POST['duracion'];

    $sql = "INSERT INTO cartelera (Nombre, Genero, Descripcion, Duracion) VALUES (:nombre, :genero, :descripcion, :duracion)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':duracion', $duracion);

    if ($stmt->execute()) {
        echo "Película creada con éxito.";
    } else {
        echo "Error al crear la película.";
    }
}

// Operación READ (Leer todas las películas)



// Operación DELETE (Eliminar una película por ID)
if (isset($_POST['eliminar'])) {
    $idEliminar = $_POST['idEliminar'];

    $sql = "DELETE FROM cartelera WHERE Id_pelicula = :idEliminar";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idEliminar', $idEliminar);

    if ($stmt->execute()) {
        echo "Película eliminada con éxito.";
    } else {
        echo "Error al eliminar la película.";
    }
}
?>

<div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
        <h2>El señor de las PELICULAS</h2>
    </div>
<br>
<ul class="menu">
<ul class="menu">
<li><a href="index.php">Inicio</a></li>
        <li><a href="crear.php">Crear</a></li>
        <li><a href="eliminar.php">Eliminar</a></li>
        
        <li><a href="ver.php">Ver</a></li>
    </ul>
    </ul>

<!-- Formulario para eliminar una película por ID -->
<h2>Eliminar Película</h2>
<form method="POST" action="">
    <label for="idEliminar">ID de la Película a Eliminar:</label>
    <input type="number" name="idEliminar" required><br>

    <input type="submit" name="eliminar" value="Eliminar Película">
</form>
</body>

</html>