<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Blog de Películas</title>
    <style>
        .movie {
            text-align: center;
            margin: 20px;
        }

        .movie img {
            max-width: 100%;
            height: auto;
        }

        .movie-description {
            text-align: left;
            padding: 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Blog de Películas</h1>

    <?php
 include 'conexion.php';

    // Consulta para obtener películas de la tabla "cartelera"
    $sql = "SELECT Nombre, Genero, Duracion, Descripcion, imagen FROM cartelera";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="movie">';
        echo '<img src="' . $row['imagen'] . '" alt="' . $row['Nombre'] . '">';
        echo '<div class="movie-description">';
        echo '<h2>' . $row['Nombre'] . '</h2>';
        echo '<p><strong>Género:</strong> ' . $row['Genero'] . '</p>';
        echo '<p><strong>Duración:</strong> ' . $row['Duracion'] . '</p>';
        echo '<p><strong>Descripción:</strong> ' . $row['Descripcion'] . '</p>';
        echo '</div>';
        echo '</div>';
    }
    ?>

</body>
</html>
