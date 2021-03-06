<!DOCTYPE html>
<html lang="es">
<?php
    session_start();

    require "../vendor/autoload.php";
    use Clases\Usuarios;

    function mostrarError($m){
        $_SESSION["error"]=$m;
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }
    if(isset($_POST['crear'])){
     $nombre=trim($_POST['nombre']);
     $pass=trim($_POST['pass']);
     $mail=trim($_POST['mail']);
     if(strlen($nombre)==0 || strlen($pass)==0 || strlen($mail)==0){
         mostrarError("Rellene los campos!!!");
     }
     $nuevoUsuario=new Usuarios();
     $nuevoUsuario->setMail($mail);

     if($nuevoUsuario->existeNombre($nombre)){
         $nuevoUsuario=null;
         mostrarError("El usuario ya existe en el sistema!!!");
     }
     if($nuevoUsuario->existeMail()){
        $nuevoUsuario=null;
        mostrarError("El mail ya existe en el sistema!!!");
     }
     //Si he llegado aquí todo esta bien
     $nuevoUsuario->setNombre($nombre);
     $passBuena=hash("sha256", $pass);
     $nuevoUsuario->setPass($passBuena);

     $nuevoUsuario->create();
     $_SESSION["mensaje"]="Usuario creado correctamente";
     $nuevoUsuario=null;
     header("Location:index.php");

     
    }
    else{
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../vendor/fortawesome/font-awesome/css/all.min.css" rel="stylesheet" />
    <title>crear usuario</title>
</head>

<body style="background-color:lightblue">
    <h3 class="text-center mt-3">Nuevo usuario</h3>

    <div class="container mt-3">
        <?php
            if(isset($_SESSION['error'])){
                echo "<p class='my-2 text-danger'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);

            }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="mb-3">
                <label for="idn" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="idn" name="nombre" required>

            </div>
            <div class="mb-3">
                <label for="idm" class="form-label">Email address</label>
                <input type="email" class="form-control" id="idm" name="mail" required>
            
            </div>
            <div class="mb-3">
                <label for="idp" class="form-label">Password</label>
                <input type="password" class="form-control" id="idp" name="pass" required>
            </div>
           
            <button type="submit" class="btn btn-primary mr-4" name="crear">Crear</button>
            <a href="index.php" class="btn btn-info">Inicio</a>




        </form>
    </div>
</body>
<?php } ?>
</html>