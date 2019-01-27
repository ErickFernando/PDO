<?php

/**
 * Description of ConexionPDO
 *
 * @author Erick Fer
 */
class ConexionPDO {

    private $host;
    private $user;
    private $pwd;
    private $bd;
    private $conex;
    private $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => true, PDO::ERRMODE_EXCEPTION => true);

    function __construct(array $conexion, $bd = "") {
        $this->host = $conexion['host'];
        $this->user = $conexion['user'];
        $this->pwd = $conexion['pwd'];
        if ($bd != "") {
            $this->bd = $bd;
            $this->conex = $this->conectar();
        }
    }

    public function conectar() {
        try {

            $con = new PDO("mysql:host=" . $this->host . "; dbname=$this->bd", $this->user, $this->pwd, $this->opciones);
            echo "Conectado";
            return $con;
        } catch (PDOException $ex) {
            echo $ex->getMessage() . "<br/>";
        }
    }

    public function muestraBD() {
        try {
            $con = new PDO("mysql:" . $this->host, $this->user, $this->pwd);
            $r = $con->prepare("show databases");
            $r->execute();
            $db = null;
            while ($f = $r->fetch(PDO::FETCH_ASSOC)) {
                $db[] = $f;
            }
            return $db;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function muestraTablas() {
      
        $r = $this->conex->prepare("show full tables");
        $r->execute();
        $tb = null;
        while ($f = $r->fetch(PDO::FETCH_ASSOC)) {
            $tb[] = $f;
        }
        return $tb;
    }

    public function muestraCampos(string $nombreTabla) {

        $consulta = $this->conex->query("select * from $nombreTabla");
//        $consulta->execute();
        $nombre_tabla = null;
//        while ($f = $consulta->fetch(PDO::FETCH_ASSOC)) {
//            $nombre_tabla[] = $f;
//        }
        $total_column = $consulta->columnCount();

        for ($counter = 0; $counter < $total_column; $counter ++) {
            $meta = $consulta->getColumnMeta($counter);
            $nombre_tabla[] = $meta['name'];
        }
        return $nombre_tabla;
    }

    public function muestraVlores(string $nombreTabla) {

        $consulta = $this->conex->query("select * from $nombreTabla");
//        $consulta->execute();
        $nombre_tabla = null;

        while ($f = $consulta->fetch(PDO::FETCH_NUM)) {
            $nombre_tabla[] = $f;
        }
        return $nombre_tabla;
    }

    public function buscaValor(string $key, string $nameTable, $id) {
        $consulta = $this->conex->prepare("select * from $nameTable where $key ='$id'");
        $consulta->execute();
        while ($f = $consulta->fetch(PDO::FETCH_ASSOC)) {
            return $f;
        }
    }

    function getHost() {
        return $this->host;
    }

    function getUser() {
        return $this->user;
    }

    function getPwd() {
        return $this->pwd;
    }

    function getBd() {
        return $this->bd;
    }

    function setHost($host) {
        $this->host = $host;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setPwd($pwd) {
        $this->pwd = $pwd;
    }

    function setBd($bd) {
        $this->bd = $bd;
    }

}
