<?php
session_start();
require "../vendor/autoload.php";

use Clases\Usuarios;


$losUsuarios = new Usuarios();
$losUsuarios->rellenarTabla(300);
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
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
        <table class="table table-striped" id="tablaUsuarios">
            <thead class="thead-dark text-light">
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
    <script>
        $(document).ready(function() {
            $('#tablaUsuarios').DataTable();
        });
    </script>
</body>

</html>