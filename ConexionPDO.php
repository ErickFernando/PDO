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

    function __construct($host, $user, $pwd) {
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->conex = $this->conectar();
    }

    private function conectar() {
        try {

            $con = new PDO("mysql:" . $this->host, $this->user, $this->pwd);
            $r = $con->prepare("show database");
            $r->execute();
            while ($f = $r->fetch(PDO::FETCH_ASSOC)) {
                var_dump($f);
            }
            return $con;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

}
