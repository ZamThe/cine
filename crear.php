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
include 'conexion.php';

// Operación CREATE (Crear una nueva película)
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $genero = $_POST['genero'];
    $descripcion = $_POST['descripcion'];
    $Fecha = $_POST['fecha'];
    $duracion = $_POST['duracion'];

    // Manejar la imagen
    $imagen = $_FILES['imagen'];

    // Verificar si se cargó una imagen
    if ($imagen['error'] === 0) {
        // Ruta donde se almacenará la imagen (puedes personalizarla)
        $ruta_imagen = "img" . $imagen['name'];

        // Mover la imagen cargada al directorio de destino
        if (move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
            // La imagen se cargó correctamente, ahora puedes insertar la película en la base de datos
            $sql = "INSERT INTO cartelera (Nombre, Genero, Descripcion, Fecha, Duracion, Imagen) VALUES (:nombre, :genero, :descripcion, :fecha, :duracion, :imagen)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fecha', $Fecha);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->bindParam(':imagen', $ruta_imagen); // Almacena la ruta de la imagen en la base de datos

            if ($stmt->execute()) {
                $mensaje = "Película creada con éxito.";
            } else {
                $mensaje = "Error al crear la película.";
            }
        } else {
            echo "Error al cargar la imagen.";
        }
    } else {
        echo "No se seleccionó ninguna imagen.";
    }
}
?>

<!-- Formulario para crear una nueva película -->
<div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
        
    </div>
    <nav>
<ul class="dropdown">
        	<li class="drop"><a href="Admin.php">Inicio</a></li>
        	<li class="drop"><a href="crea_serie.php">Crear Serie</a></li>
        	<li class="drop"><a href="ver.php">Ver Peliculas</a></li>
        	<li><a href="Index.php">Salir</a>
        	</li>
        </ul>
</nav> 
<br>
<div id="login-form-wrap">
<h2>Crear Película</h2>
<form method="POST" action="" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required><br>

    <label for="genero">Género:</label>
    <input type="text" name="genero" required><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required></textarea><br>
    <label for="fecha">Fecha estreno</label>
        <input type="date" name="fecha" required><br>

    <label for="duracion">Duración:</label>
    <input type="number" name="duracion" required><br>
    
    <label for="imagen">Imagen:</label>
    <input type="file" name="imagen" accept="image/*"><br>

    <!-- Agrega el dropdown para los directores -->
    <br><label for="director">Director:</label>
    <select name="director">
        <?php
        // Consulta para obtener la lista de directores desde la tabla director
        $sqlDirectores = "SELECT * FROM director";
        $stmtDirectores = $pdo->query($sqlDirectores);

        // Itera a través de los directores y crea las opciones del dropdown
        while ($rowDirector = $stmtDirectores->fetch(PDO::FETCH_ASSOC)) {
            $id_director = $rowDirector['id_director'];
            $nombre_director = $rowDirector['Nombre_director'];
            echo "<option value='$id_director'>$nombre_director</option>";
        }
        ?>
    </select><br>
    <br><label for="productora">Productora:</label>
    <select name="productora">
    <?php
    // Consulta para obtener la lista de productoras desde la tabla productora
    $sqlproductora = "SELECT * FROM productora";
    $stmtproductora = $pdo->query($sqlproductora);

    // Itera a través de las productoras y crea las opciones del dropdown
    while ($rowproductora = $stmtproductora->fetch(PDO::FETCH_ASSOC)) {
        $id_productora = $rowproductora['id_productora'];
        $Nombre_pro = $rowproductora['Nombre_pro']; // Corrección aquí
        echo "<option value='$id_productora'>$Nombre_pro</option>";
    }
    ?>
    </select>
    </select><br>
    <br><input type="submit" name="crear" value="Crear Película">
    </form>
    </div>
    <script>
    <?php
    // Imprime el valor de $mensaje como una variable JavaScript
    echo "var mensaje = '" . addslashes($mensaje) . "';";
    ?>

    // Muestra el alert en JavaScript
    if (mensaje) {
        alert(mensaje);
    }
</script>
</body>
</html>