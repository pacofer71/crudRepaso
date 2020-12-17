<?php

namespace Clases;

use PDO;
use PDOException;
use Faker;

require "../vendor/autoload.php";
class Usuarios extends Conexion
{
    private $id;
    private $nombre;
    private $pass;
    private $mail;

    public function __construct()
    {
        parent::__construct();
    }
    //---------------CRUD
    public function create()
    {
        $c = "insert into usuarios(nombre, pass, mail) values(:n, :p, :m)";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':p' => $this->pass,
                ':m' => $this->mail
            ]);
        } catch (PDOException $ex) {
            die("Error al crear el usuario");
        }
    }
    public function read()
    {
        $c = "select * from usuarios";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar todos los datos: " . $ex->getMessage());
        }
        return $stmt;
    }
    public function update()
    {
        $c="update usuarios set nombre=:n, mail=:m, pass=:p where id=:i";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute([
                ':i' => $this->id,
                ':n' => $this->nombre,
                ':p' => $this->pass,
                ':m' => $this->mail
                ]);
        } catch (PDOException $ex) {
            die("Error al actualizar usuario: " . $ex->getMessage());
        }
    }
    public function delete()
    {
        $c = "delete from usuarios where id=:i";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute([':i' => $this->id]);
        } catch (PDOException $ex) {
            die("Error al borrar usuario: " . $ex->getMessage());
        }
    }

    //setters--------------------------------------
    public function setId($i)
    {
        $this->id = $i;
    }
    public function setNombre($n)
    {
        $this->nombre = $n;
    }
    public function setPass($p)
    {
        $this->pass = $p;
    }
    public function setMail($m)
    {
        $this->mail = $m;
    }
    //Otros metodos-------------------------------------------------------
    public function existeNombre($n)
    {
        if (!isset($this->id)) {
            $c = "select count(*) as total from usuarios where nombre=:n";
        } else {
            $c = "select count(*) as total from usuarios where nombre=:n and id!=$this->id";
        }
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute([':n' => $n]);
        } catch (PDOException $ex) {
            die("Error al comprobar si existe el nombre: " . $ex->getMessage());
        }
        $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
        return $total;
    }
    public function existeMail()
    {
        if (!isset($this->id)) {
            $c = "select count(*) as total from usuarios where mail=:m";
        } else {
            $c = "select count(*) as total from usuarios where mail=:m and id!=$this->id";
        }

        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute([':m' => $this->mail]);
        } catch (PDOException $ex) {
            die("Error al comprobar si existe el mail: " . $ex->getMessage());
        }
        $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
        return $total;
    }
    //devolver un usuario concreto
    public function devolverUsuario()
    {
        $c = "select * from usuarios where id=:i";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute([':i' => $this->id]);
        } catch (PDOException $ex) {
            die("Error al devolver un usuario: " . $ex->getMessage());
        }
        return $stmt;
    }
    public function hayDatos(){
        $c="select count(*) as total from usuarios";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar el numero deusuarios: " . $ex->getMessage());
        }
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }
    public function rellenarTabla($cantidad){
        if(!$this->hayDatos()){
            $faker=Faker\Factory::create('es_ES');
            for($i=0; $i<$cantidad; $i++){
                $nombre=$faker->unique()->userName;
                $pass=$faker->sha256;
                $mail=$faker->unique()->freeEmail;
                $c="insert into usuarios(nombre, pass, mail) values('$nombre', '$pass', '$mail')";
                $stmt=parent::$conexion->prepare($c);
                $stmt->execute();
            }
        }

    }
    //-----------------------------------------------------------------------
}
