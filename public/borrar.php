<?php
session_start();
if(!isset($_POST['codigo'])){
    header("Location:index.php");
    die();
}
require "../vendor/autoload.php";
use Clases\Usuarios;

$id=$_POST['codigo'];
//die("Usuario a borrar $id");
$usuario= new Usuarios();
$usuario->setId($id);
$usuario->delete();
$usuario=null;
$_SESSION["mensaje"]="Usuario Borrado Correctamente";
header("Location:index.php");
