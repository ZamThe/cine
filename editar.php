<?php
include 'conexion.php';
// Verificar si se ha enviado un formulario de edición
if(isset($_POST['editar_id'])) {
    // Procesar el formulario y actualizar los datos en la base de datos
    $id_a_editar = $_POST['editar_id'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_genero = $_POST['nuevo_genero'];
    $nueva_descripcion = $_POST['nueva_descripcion'];
    $nueva_duracion = $_POST['nueva_duracion'];

    // Realiza la actualización en la base de datos aquí
    $sql_actualizar = "UPDATE cartelera SET Nombre = :nombre, Genero = :genero, Descripcion = :descripcion, Duracion = :duracion WHERE id_pelicula = :id";
    $stmt_actualizar = $pdo->prepare($sql_actualizar);
    $stmt_actualizar->bindParam(':id', $id_a_editar, PDO::PARAM_INT);
    $stmt_actualizar->bindParam(':nombre', $nuevo_nombre, PDO::PARAM_STR);
    $stmt_actualizar->bindParam(':genero', $nuevo_genero, PDO::PARAM_STR);
    $stmt_actualizar->bindParam(':descripcion', $nueva_descripcion, PDO::PARAM_STR);
    $stmt_actualizar->bindParam(':duracion', $nueva_duracion, PDO::PARAM_INT);

    if ($stmt_actualizar->execute()) {
        // Redirige a la página principal después de actualizar
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error al actualizar la película.";
    }
} else {
    // Mostrar el formulario de edición con los detalles de la película seleccionada
    if(isset($_GET['editar_id'])) {
        $id_a_editar = $_GET['editar_id'];
        $sql_seleccionar = "SELECT * FROM cartelera WHERE id_pelicula = :id";
        $stmt_seleccionar = $pdo->prepare($sql_seleccionar);
        $stmt_seleccionar->bindParam(':id', $id_a_editar, PDO::PARAM_INT);
        $stmt_seleccionar->execute();
        $pelicula = $stmt_seleccionar->fetch(PDO::FETCH_ASSOC);
    } else {
        // Manejar el caso en el que no se proporciona un ID válido para editar
        echo "ID de película no válido.";
        exit();
    }
}

// Aquí debes mostrar el formulario de edición con los detalles de $pelicula y campos para editar.
?>

<!-- Código HTML del formulario de edición -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Película</title>
</head>
<body>
    <h2>Editar Película</h2>
    <form method="POST" action="editar.php">
        <input type="hidden" name="editar_id" value="<?php echo $pelicula['id_pelicula']; ?>">
        <label for="nuevo_nombre">Nombre:</label>
        <input type="text" name="nuevo_nombre" value="<?php echo $pelicula['Nombre']; ?>"><br>
        
        <label for="nuevo_genero">Género:</label>
        <input type="text" name="nuevo_genero" value="<?php echo $pelicula['Genero']; ?>"><br>
        
        <label for="nueva_descripcion">Descripción:</label>
        <textarea name="nueva_descripcion"><?php echo $pelicula['Descripcion']; ?></textarea><br>
        
        <label for="nueva_duracion">Duración:</label>
        <input type="text" name="nueva_duracion" value="<?php echo $pelicula['Duracion']; ?>"><br>
        
        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>
