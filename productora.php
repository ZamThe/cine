<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "cine";

$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
include 'conexion.php';
$id_productora = "";
$Nombre_pro = "";
$Fecha = "";
$Descripcion = "";
if (isset($_POST['guardar'])) {
    $Nombre_pro = $_POST['Nombre_pro'];
    $Fecha = $_POST['Fecha'];
    $Descripcion = $_POST['Descripcion'];
    if (empty($_POST['id_productora'])) {
        // Insertar un nuevo registro
        $sql = "INSERT INTO productora (Nombre_pro, Fecha, Descripcion) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $Nombre_pro, $Fecha, $Descripcion);
        if ($stmt->execute()) {
            echo "Registro insertado correctamente.";
        } else {
            echo "Error al insertar el registro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Actualizar un registro existente
        $id_productora = $_POST['id_productora'];
        $sql = "UPDATE productora SET Nombre_pro=?, Fecha=?, Descripcion=? WHERE id_productora=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $Nombre_pro, $Fecha, $Descripcion, $id_productora);
        if ($stmt->execute()) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Productora</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
 
<div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
   
    </div>
    <nav>
<ul class="dropdown">
        	<li class="drop"><a href="Admin.php">Inicio</a></li>
            <ul class="sub_menu">
        			<li><a href="#">Lorem</a></li>
							<li><a href="#">Ipsum</a></li>
							<li><a href="#">Dolor</a></li>				
        		</ul>
        	<li class="drop"><a href="director.php">Crear directores</a></li>   	
        	<li><a href="Index.php">Salir</a>
        	</li>
        </ul>
</nav> 
<br><br><div id="login-form-wrap">
    <h2>Crear Productora</h2>
    <form action="" method="post">
        <input type="hidden" name="id_productora" value="<?php echo $id_productora; ?>">
        <label for="Nombre_pro">Nombre de la Productora:</label>
        <input type="text" name="Nombre_pro" required value="<?php echo $Nombre_pro; ?>"><br>
        <label for="Fecha">Fecha de creación productora:</label>
        <input type="date" name="Fecha" required value="<?php echo $Fecha; ?>"><br><br>
        <label for="Descripcion">Descripción:</label>
        <textarea name="Descripcion" required><?php echo $Descripcion; ?></textarea><br>
        <input type="submit" name="guardar" value="Guardar">
    </form>
</div>
</body>
</html>