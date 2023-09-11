<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>HTML5 Login Form with validation Example</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="./style.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>
<br>
<body>
<div class="image-and-text">
        <img src="img/logo.png" alt="Imagen">
        <h2>El señor de las PELICULAS</h2>
    </div>
<ul class="menu">
    
<li><a href="index.php">Inicio</a></li>
        <li><a href="crear.php">Crear</a></li>
        <li><a href="eliminar.php">Eliminar</a></li>
        
        <li><a href="#">Ver</a></li>
    </ul>
<!-- partial:index.partial.html -->
<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Inicializar variables para el mensaje de error
$username_error = $password_error = $login_error = "";

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores ingresados en el formulario
    $username = $_POST["username"];
    $password = $_POST["password"]; // Cambia "password" por el nombre de campo real en tu formulario

    // Validar el usuario y la contraseña
    $username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

$sql = "SELECT * FROM login WHERE Nombre = :username AND Contraseña = :password";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->execute();

    // Comprobar si se encontró un usuario válido
    if ($stmt->rowCount() == 1) {
        // Usuario válido, redireccionar a la página de inicio
        header("location: Admin.php"); 
        exit();
    } else {
        // Usuario o contraseña incorrectos
        $login_error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
    <br>
<div id="login-form-wrap">
    <h2>Login</h2>
    <form id="login-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p>
            <input type="text" id="username" name="username" placeholder="Username" required>
        </p>
        <p>
            <input type="password" id="password" name="password" placeholder="Password" required>
        </p>
        <p>
            <input type="submit" id="login" value="Login">
        </p>
        <p style="color: red;"><?php echo $login_error; ?></p>
    </form>
    <div id="create-account-wrap">
        <!-- Enlace para crear una cuenta -->
    </div>
</div>
</body>
</html>

</html>