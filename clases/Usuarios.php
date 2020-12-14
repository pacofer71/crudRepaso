<?php
namespace Clases;
use PDO;
use PDOException;
require "../vendor/autoload.php";
class Usuarios extends Conexion{
    private $id;
    private $nombre;
    private $pass;
    private $mail;

    public function __construct()
    {
        parent::__construct();
    }
    //---------------CRUD
    public function create(){

    }
    public function read(){
        $c="select * from usuarios";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar todos los datos: ".$ex->getMessage());
        }
        return $stmt;
    }
    public function update(){

    }
    public function delete(){

    }

    //setters--------------------------------------
    public function setId($i){
        $this->id=$i;
    }
    public function setNombre($n){
        $this->nombre=$n;
    }
    public function setPass($p){
        $this->pass=$p;
    }
    public function setMail($m){
        $this->mail=$m;
    }
}