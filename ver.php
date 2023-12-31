<html>
<head>
    <meta charset="UTF-8">
    <title>Crear Película</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
    
    </div>
    <nav>
    <ul class="dropdown">
        	<li class="drop"><a href="Admin.php">Inicio</a></li>
        	<li class="drop"><a href="crear.php">Regresar</a></li>
        	<li class="drop"><a href="eliminar.php">Eliminar pelicula</a></li>
        	<li><a href="Index.php">Salir</a>
        	</li>
        </ul>
</nav> 
<?php
include 'conexion.php';
if(isset($_GET['eliminar_id'])){
    // Realiza la eliminación en la base de datos aquí
    $id_a_eliminar = $_GET['eliminar_id'];
    $sql_eliminar = "DELETE FROM cartelera WHERE id_pelicula = :id";
    $stmt_eliminar = $pdo->prepare($sql_eliminar);
    $stmt_eliminar->bindParam(':id', $id_a_eliminar, PDO::PARAM_INT);
    
    if ($stmt_eliminar->execute()) {
        // Redirige a la página actual después de eliminar
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error al eliminar la película.";
    }
}

// Consulta para obtener la lista de películas
$sql = "SELECT * FROM cartelera";
$stmt = $pdo->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Películas</title>
</head>
<body>
    <h2>Listado de Películas</h2>
    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Género</th>
            <th>Descripción</th>
            <th>Duración</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id_pelicula']; ?></td>
                <td><?php echo $row['Nombre']; ?></td>
                <td><?php echo $row['Genero']; ?></td>
                <td><?php echo $row['Descripcion']; ?></td>
                <td><?php echo $row['Duracion']; ?></td>
                <td><img src='<?php echo $row['imagen']; ?>' width='100' height='100'></td>
                <td>
                    <button onclick="confirmDelete(<?php echo $row['id_pelicula']; ?>)">Eliminar</button>
                    <button id="confirmButton_<?php echo $row['id_pelicula']; ?>" style="display:none;" onclick="deleteRow(<?php echo $row['id_pelicula']; ?>)">Confirmar</button>
                    <button><a href="detalles.php?id=<?php echo $row['id_pelicula']; ?>" target="_blank">Detalles</a></button>
                </td>
                
            </tr>
        <?php } ?>
    </table>

    <script>
        function confirmDelete(id) {
            // Mostrar el botón "Confirmar" correspondiente a la fila seleccionada
            document.getElementById("confirmButton_" + id).style.display = "inline";
        }

        function deleteRow(id) {
            // Redirige a la página "eliminar.php" con el ID a eliminar
            window.location.href = "eliminar.php?eliminar_id=" + id;
        }
    </script>



