<!DOCTYPE html>
<html>
<head>
    <title>Dropdown de Productoras</title>
</head>
<body>
    <h2>Selecciona una Productora:</h2>
    <form action="" method="post">
        <label for="productora">Productora:</label>
        <select name="productora" id="productora">
            <?php
            $host = "localhost";
            $usuario = "root";
            $contrasena = "";
            $base_de_datos = "cine";

            $conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Consulta SQL para obtener las productoras de la tabla "productora"
            $sql = "SELECT id_productora, Nombre_pro FROM productora";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id_productora = $row['id_productora'];
                    $Nombre_pro = $row['Nombre_pro'];
                    echo "<option value='$id_productora'>$Nombre_pro</option>";
                }
            } else {
                echo "<option value=''>No hay productoras disponibles</option>";
            }

            $conexion->close(); // Cierra la conexión a la base de datos
            ?>
        </select><br>

        <!-- Resto de los campos y botones aquí -->
        <input type="submit" name="guardar" value="Guardar">
    </form>
</body>
</html>
