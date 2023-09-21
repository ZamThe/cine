<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Serie</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
        <h2>El señor de las SERIES</h2>
    </div>
    <nav>
        <ul class="dropdown">
            <li class="drop"><a href="Admin.php">Inicio</a></li>
            <li class="drop"><a href="crear.php">Crear Películas</a></li>
            <li class="drop"><a href="#">Ver series</a></li>
            <li><a href="Index.php">Salir</a></li>
        </ul>
    </nav>
    <br>
    <div id="login-form-wrap">
        <h2>Editar Serie</h2>
        <?php
        include 'conexion.php';

        // Verificar si se proporciona un ID válido para editar
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id_editar = $_GET['id'];

            // Consultar la serie a editar desde la base de datos
            $sql = "SELECT * FROM serie WHERE id_serie = :id_editar";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_editar', $id_editar);
            $stmt->execute();

            // Obtener los datos de la serie a editar
            $serie_editar = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si se encontró la serie a editar
            if ($serie_editar) {
                $nombre = $serie_editar['Nombre_serie'];
                $sinopsis = $serie_editar['Sinopsis_serie'];
                $fecha = $serie_editar['fecha_serie'];
                $ruta_imagen = $serie_editar['Imagen_serie'];
                ?>
                <!-- Formulario para editar la serie -->
                <form method="POST" action="procesar_edicion.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id_editar; ?>">
                    <label for="nombre">Nombre de la Serie:</label>
                    <input type="text" name="nombre" required value="<?php echo $nombre; ?>"><br>

                    <label for="sinopsis">Sinopsis:</label>
                    <textarea name="sinopsis" required><?php echo $sinopsis; ?></textarea><br>

                    <br><label for="fecha">Fecha de Estreno:</label>
                    <input type="date" name="fecha" required value="<?php echo $fecha; ?>"><br>

                    <br><label for="imagen">Imagen:</label>
                    <input type="file" name="imagen" accept="image/*"><br>

                    <br><input type="submit" name="editar" value="Guardar Cambios">
                </form>
                <?php
            } else {
                echo "La serie a editar no existe.";
            }
        } else {
            echo "ID de serie no válido para editar.";
        }
        ?>
    </div>
</body>
</html>