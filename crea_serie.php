<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Crear Serie</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css"> <!-- Enlaza tu archivo CSS externo aquí -->
</head>
<body>
    <div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
        <h2>El señor de las SERIES</h2>
    </div>
    <ul class="menu">
        <li><a href="Admin.php">Inicio</a></li>
        <li> <a href="crear.php">Crea Peliculas</a></li>
        <li><a href="productora.php">Crear productora</a></li>
        <li class="submenu">
            <a href="director.php">Crear Directores</a>
        </li>
        <li class="submenu">
            <a href="ver.php">Ver</a>
            <ul class="sub-menu">
                <li><a href="ver.php">Ver opción 1</a></li>
                <li><a href="ver.php">Ver opción 2</a></li>
            </ul>
        </li>
    </ul>
    <br>
    <div id="login-form-wrap">
        <h2>Crear Serie</h2>
        <?php
        include 'conexion.php';

        // Operación CREATE (Crear una nueva serie)
        if (isset($_POST['crear'])) {
            $nombre = $_POST['nombre'];
            $sinopsis = $_POST['sinopsis'];
            $fecha = $_POST['fecha'];

            // Manejar la imagen
            $imagen = $_FILES['imagen'];

            // Verificar si se cargó una imagen
            if ($imagen['error'] === 0) {
                // Ruta donde se almacenará la imagen (puedes personalizarla)
                $ruta_imagen = "img/" . $imagen['name'];

                // Mover la imagen cargada al directorio de destino
                if (move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
                    // La imagen se cargó correctamente, ahora puedes insertar la serie en la base de datos
                    $sql = "INSERT INTO serie (Nombre_serie, Sinopsis_serie, fecha_serie, Imagen_serie) VALUES (:nombre, :sinopsis, :fecha, :imagen)";
                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':sinopsis', $sinopsis);
                    $stmt->bindParam(':fecha', $fecha);
                    $stmt->bindParam(':imagen', $ruta_imagen); // Almacena la ruta de la imagen en la base de datos

                    if ($stmt->execute()) {
                        echo "Serie creada con éxito.";
                    } else {
                        echo "Error al crear la serie.";
                    }
                } else {
                    echo "Error al cargar la imagen.";
                }
            } else {
                echo "No se seleccionó ninguna imagen.";
            }
        }
        ?>

        <!-- Formulario para crear una nueva serie -->
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="nombre">Nombre de la Serie:</label>
            <input type="text" name="nombre" required><br>

            <label for="sinopsis">Sinopsis:</label>
            <textarea name="sinopsis" required></textarea><br>

            <br><label for="fecha">Fecha de Estreno:</label>
            <input type="date" name="fecha" required><br>

            <br><label for="imagen">Imagen:</label>
            <input type="file" name="imagen" accept="image/*"><br>

            <br><input type="submit" name="crear" value="Crear Serie">
        </form>
    </div>
</body>
</html>
