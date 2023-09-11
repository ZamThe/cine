<html>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/styles.css">
<style>
</style>
<head>
    <meta charset="UTF-8">
    <title>Crear Película</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Enlaza tu archivo CSS externo aquí -->
</head>
<?php
$host = "localhost";
$dbname = "cine";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

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
?>
<!-- Formulario para crear una nueva película -->
<div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
        <h2>El señor de las PELICULAS</h2>
    </div>
<ul class="menu">
    <li><a href="index.php">Inicio</a></li>
    <li><a href="productora.php">Crear productora</a></li>
    <li class="submenu">
        <a href="director.php">Crear Directores</a>
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
<body>
<h2>Crear Película</h2>
<form method="POST" action="">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required><br>

    <label for="genero">Género:</label>
    <input type="text" name="genero" required><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required></textarea><br>

    <label for="duracion">Duración:</label>
    <input type="text" name="duracion" required><br>
    <label for="imagen">Imagen:</label>
    <input type="file" name="imagen" accept="image/*"><br>
    <input type="submit" name="crear" value="Crear Película">
</form>
</body>
</html>