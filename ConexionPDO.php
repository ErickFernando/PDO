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
    private $conex;
    private $bd;

    function __construct($host, $user, $pwd, string $bd = "") {
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->bd = $bd;
        
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

    private function conectar() {
        try {
            $con = new PDO("mysql:" . $this->host."; dbname=".$this->bd, $this->user, $this->pwd);
            echo "logeado";

            $this->conex = $con;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    function getConex() {
        return $this->conex;
    }

    function setConex($conex) {
        $this->conex = $conex;
    }



}
