<?php
session_start();
require "../vendor/autoload.php";

use Clases\Usuarios;
//use PDO;

$losUsuarios = new Usuarios();
$datos = $losUsuarios->read();
$losUsuarios = null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../vendor/fortawesome/font-awesome/css/all.min.css" rel="stylesheet" />
    <title>Usuarios</title>
</head>

<body style="background-color:lightblue">
    <h3 class="text-center mt-3">Gestión de Usuarios</h3>

    <div class="container mt-3">
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<p class='my-2 text-success'>{$_SESSION['mensaje']}</p>";
            unset($_SESSION['mensaje']);
        }
        ?>
        <a href="crear.php" class="btn btn-success my-3">Crear Usuario</a>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $datos->fetch(PDO::FETCH_OBJ)) {
                    echo <<<TXT
                <tr>
                    <th scope="row">{$fila->id}</th>
                    <td>{$fila->nombre}</td>
                    <td>{$fila->mail}</td>
                    <td>
                    <form name="a" action="borrar.php" method='POST' class="form-inline">
                    <input type="hidden" name="codigo" value='{$fila->id}' />
                    <a href="update.php?id={$fila->id}" class="btn btn-warning mr-2">Editar</a>
                    <button type="submit" class="btn btn-danger">Borrar</button>
                    </form>
                    </td>
                </tr>
TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>