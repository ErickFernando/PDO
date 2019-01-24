<?php
/**
 * Description of ConexionBD
 *
 * @author Erick Fer
 */
class ConexionBD extends ConexionPDO {

//    private $host2;
//    private $user2;
//    private $pwd2;
    private $bd;
    private $conex;
    private $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => true, PDO::ERRMODE_EXCEPTION => true);

    public function __construct(string $host, string $user, string $pwd,string $bd) {
     
        parent::__construct("mysql:host=" .$host . "; dbname=$bd", $user, $pwd);
        $this->conex = $this->conectar();
    }

    public function conectar() {
        try {
          
            $con = new PDO($this->getHost(), $this->getUser(), $this->getPwd(),$this->opciones);
            echo "Conectado";
            return $con;
        } catch (PDOException $ex) {
            echo $ex->getMessage(). "<br/>";
        }
    }

    public function muestraTablas() {
        $resul = $this->conex->prepare("SHOW FULL TABLES");
        $resul->execute();
        $dbTables = null;
        while ($f = $resul->fetch(PDO::FETCH_ASSOC)) {
            $dbTables[] = $f;
        }
        return $dbTables;
    }
    



}
