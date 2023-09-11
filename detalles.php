<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Película</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
      /* Estilos para el contenedor */
      .text-container {
            background-color: #f2f2f2; /* Color de fondo */
            padding: 20px; /* Espacio de relleno */
            border: 1px solid #ddd; /* Borde */
            border-radius: 5px; /* Bordes redondeados */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Sombra */
            text-align: center; /* Alineación del texto */
        }
        
        /* Estilos para el texto dentro del contenedor */
        .text-container p {
            font-size: 16px; /* Tamaño de fuente */
            color: #333; /* Color del texto */
        }
    </style>
</head>
<body>
    <div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
        <h2>El señor de las PELICULAS</h2>
    </div>
    <ul class="menu">
        <li><a href="Admin.php">Inicio</a></li>
        <li><a href="catalogo_peliculas.php">Ver peliculas</a></li>
        <li><a href="series.php">Ver series</a></li>
        <li><a href="login.php">Login</a></li>
    </ul>
  
    
    <div class="blog-entry">
        
        <div class="blog-post">
            <h1>Detalles de la Película</h1>
            <?php
            // Obtener los detalles de la película según el ID proporcionado en la URL
            if (isset($_GET['id'])) {
                $id_pelicula = $_GET['id'];

                include 'conexion.php';
                $sql = "SELECT * FROM cartelera WHERE id_pelicula = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id_pelicula, PDO::PARAM_INT);
                $stmt->execute();
                $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<img class='blog-image' src='{$pelicula['imagen']}' alt='{$pelicula['Nombre']}'>";
            }
            
            ?>
        </div>
    </div>

 <h2>Descripción </h2>
          
            <?php
            // Obtener los detalles de la película según el ID proporcionado en la URL
            if (isset($_GET['id'])) {
                $id_pelicula = $_GET['id'];

                include 'conexion.php';
                $sql = "SELECT * FROM cartelera WHERE id_pelicula = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id_pelicula, PDO::PARAM_INT);
                $stmt->execute();
                $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($pelicula) {
                    echo "<h2> Nombre pelicula <br>{$pelicula['Nombre']}</h2>";
                    
                    echo "<p> {$pelicula['Descripcion']}</p>";
              

                    echo "";

                } else {
                    echo "Película no encontrada.";
                }
            } else {
                echo "ID de película no proporcionado.";
            }
            
            ?>
             <iframe width="560" height="315" src="https://www.youtube.com/embed/TU_ID_DE_VIDEO" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>

  
    <footer>
        &copy; 2023 El señor de las peliculas
    </footer>
</body>
</html>

