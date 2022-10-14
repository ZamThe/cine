<?php

    session_start();

    //Llamar base de datos
    require 'database/database.php';

    //Establecer zona horario y variables de hora/fecha actual
    date_default_timezone_set('America/Bogota');
    $fechaActual = date("y-m-d");
    $horaActual = date("H:i:s", time()); 

    if(isset($_POST['ingresarFormulario'])) {

        //global $connect;

        //Capturar datos del formulario 
        $usuarioPost = $_POST['usuario'];
        $passwordPost = $_POST['password'];

        //Traer los datos del usuario
        $ingresar = $connect->prepare("SELECT * FROM users WHERE user = '$usuarioPost'");
        if($ingresar->execute()){
            $datosUsuario = $ingresar->fetch();
        }
    
        //Verificar si el usuario existe
        if(!empty($datosUsuario)) {

            //Verificar si su contraseña es correcta
            if($passwordPost == $datosUsuario['password']) {

                //Crear variable de sesión
                $_SESSION['permisos'] = $datosUsuario['rol'];
                $_SESSION['idUsuario'] = $datosUsuario['id'];
                //Redirigir al dashboard
                echo "<script>location.href='dashboard.php';</script>";  
                
            }else {
                $msg = 'Verifique sus credenciales.';
            }   

        }else {    
            $msg = 'Verifique sus credenciales.';  
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Control de activiades de Agricola" />
        <meta name="author" content="Mateo Guio" />
        <meta name="keywords" content="Agricola del Caribe, Control de actividades, Control de erradicadores">
        <title>Control de actividades - Agricola del Caribe</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/img/AGRICONTROL.ico"/>
        <!-- Bootstrap NPM -->
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!--<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">-->
        <!-- Bs icons -->
        <!-- <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <!-- Select2 Bower -->
        <!-- <link href="../bower_components/select2/dist/css/select2.min.css" rel="stylesheet" /> -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Main css -->
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body class="bg-login">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-6 col-lg-3 col-xl-3 text-center">
                    <img src="assets/img/logoAgricola.png" class="img-fluid" alt="aqui va su logo">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-xl-4">
                    <div class="card shadow-lg bg-dark opacity9 rounded-lg mt-5 p-2">
                        <div class="card-body">
                            <form method="POST" action="">
                                <div>
                                    <label class="small mb-2 mt-2 text-white fw-bold" for="ususario">Usuario</label>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="usuario" name="usuario" type="text" placeholder="Digite su usuario" required/>
                                </div>
                                <div class="">
                                    <label class="small mb-2 mt-2 text-white fw-bold" for="password">Contraseña</label>
                                </div>
                                <div class="input-group">
                                    <input class="form-control" id="password" name="password" type="password" placeholder="Digite su contraseña" required/>
                                    <span class="input-group-text" id="verClaveBoton" style="cursor:pointer;"><i class="bi bi-eye-slash-fill" id="iconoVerPassword"></i></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                    <input type="submit" name="ingresarFormulario" class="btn btn-light form-control" value="Ingresar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <!-- Jquery Bower -->
        <!-- <script src="../bower_components/jquery/dist/jquery.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <!-- Select2 bower -->
        <!-- <script src="../bower_components/select2/dist/js/select2.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <!--<link rel="stylesheet" href="../node_modules/bootstrap/dist/js/bootstrap.min.js">-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script>

            //Capture button for change icon 
            var botonVerClave = document.getElementById("verClaveBoton");
            //Capture the icon
            var iconoVerPass = document.getElementById("iconoVerPassword");
            //Adicionar un event listener 
            botonVerClave.addEventListener('click', ()=>{

                //Capture the class of the icon
                var claseIcono = document.getElementById("iconoVerPassword").className;
                //Capture the input of password
                var iptPass = document.getElementById("password")

                if(claseIcono == 'bi bi-eye-fill'){
                    //Change state of the eye icon if icon has slash
                    iconoVerPass.className = "bi bi-eye-slash-fill";
                    //Capture type of input  
                    iptPass.type = "password"
                }

                if(claseIcono == 'bi bi-eye-slash-fill' ){
                    //Change state of the eye icon if icon has slash
                    iconoVerPass.className = "bi bi-eye-fill";
                    //Capture type of input  
                    iptPass.type = "text"    
                }
            })
        </script>
    </body>
</html>
