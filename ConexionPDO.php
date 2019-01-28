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

    /**
     * incializamos los atributos y comprobamos que haya una pase de 
     * datos para iniciar el atributo $bd
     * @param array $conexion
     * @param type $bd
     */
    function __construct(array $conexion, $bd = "") {
        $this->host = $conexion['host'];
        $this->user = $conexion['user'];
        $this->pwd = $conexion['pwd'];
        if ($bd != "") { //si es disinto de vacio lo inicializo
            $this->bd = $bd;
            $this->conex = $this->conectar();
        }
    }

    /**
     * conectamos a la base de datos
     * devuelve la conexion
     * @return \PDO
     */
    public function conectar() {
        try {

            $con = new PDO("mysql:host=" . $this->host . "; dbname=$this->bd", $this->user, $this->pwd, $this->opciones);

            return $con;
        } catch (PDOException $ex) {
            echo $ex->getMessage() . "<br/>";
        }
    }

    /**
     * mostramos las bases de datos que existen
     * o muestra un error de pdoException
     * @return array
     */
    public function muestraBD(): array {
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

    /**
     * mostramos las tablas de la base datos
     * seleccionada
     * @return array
     */
    public function muestraTablas(): array {
        $r = $this->conex->prepare("show full tables");
        $r->execute();


        $tb = [];
        if ($r->fetch(PDO::FETCH_ASSOC) != null) {
            while ($f = $r->fetch(PDO::FETCH_ASSOC)) {
                $tb[] = $f;
            }
           
            return $tb;
        }
    }

    /**
     * mostramos los valores de la tabla seleccionada
     * 
     * @param string $nombreTabla
     * @return array
     */
    public function muestraCampos(string $nombreTabla): array {

        $consulta = $this->conex->query("select * from $nombreTabla");
        $muestra_campos = null;
        //obtenemos el numero de columnas
        $total_column = $consulta->columnCount();
        //nos recorremos 

        for ($counter = 0; $counter < $total_column; $counter ++) {
            //obtenemos los campos de cada columna y los guardamos en un array
            $meta = $consulta->getColumnMeta($counter);
            $muestra_campos[] = $meta['name'];
        }
        return $muestra_campos;
    }

    /**
     * mostramos los valores de la tabla seleccionada
     * @param string $nombreTabla
     * @return type
     */
    public function muestraVlores(string $nombreTabla) {

        $consulta = $this->conex->query("select * from $nombreTabla");
//        $consulta->execute();
        $nombre_tabla = null;

        while ($f = $consulta->fetch(PDO::FETCH_NUM)) {
            $nombre_tabla[] = $f;
        }
        return $nombre_tabla;
    }

    /**
     * buscamos el valor de la fila seleccionada 
     * necesitaremos el campo de la columna, el valor del campo
     * y el nombre de la tabla
     * @param string $key
     * @param string $nameTable
     * @param type $id
     * @return type
     */
    public function buscaValor(array $key, string $nameTable, $id) {
        
        $consulta = $this->conex->prepare("select * from $nameTable where $key[0] ='$id'");
        $consulta->execute();
        while ($f = $consulta->fetch(PDO::FETCH_ASSOC)) {
            return $f;
        }
    }

//    /**
//     * 
//     * @param string $nameTable
//     * @return type
//     */
//    public function buscaValor2(string $nameTable) {
//        $consulta = $this->conex->prepare("select * from $nameTable");
//        $consulta->execute();
//        while ($f = $consulta->fetch(PDO::FETCH_ASSOC)) {
//            return $f;
//        }
//    }

    /**
     * Hacemos un update de la tabla seleccionada
     * necesitamos el nombre de la columna, nombre de la tabla
     * el valor del campo y los nuevos datos cambiados
     * @param array $key
     * @param string $nomTabla
     * @param type $id
     * @param array $datosAC
     * @return boolean
     */
    public function update(array $key, string $nomTabla, $id, array $datosAC) {
        //iremos construyendo la sentencia poco
        $consulta = "update $nomTabla set ";
        //recuperamos el mnombre de la columna y el valor introducido y lo concatemos
        for ($index = 0; $index < count($key); $index++) {
            $consulta .= $key[$index] . "='$datosAC[$index]', ";
        }
        //borramos la ultima coma ","
        $consulta = substr($consulta, 0, -2);
        //concatenamos el where con la primea columna  (el nombre de la columna) y el id
        $consulta .= " where $key[0] = '$id'";
        //ejecutamos la sentencia
        $ejecutar = $this->conex->prepare($consulta);
        if ($ejecutar->execute() === true) {
            return true;
        }
    }

    /**
     * insertar nuevas filas en una tabla seleccionada, para ello
     * necesitamos el nombre de la tabla, los campos a rellenar y los nuevos valores 
     * ingresados
     * @param array $key
     * @param string $nombreTabla
     * @param array $valorsInput
     * @return boolean
     */
    public function insert(array $key, string $nombreTabla, array $valorsInput) {
        //iremos construyendo la sentencia segun los valores que tengamos
        $consulta = "insert into $nombreTabla (";
        for ($index = 0; $index < count($key); $index++) {
            $consulta .= $key[$index] . ", ";
        }
        $consulta = substr($consulta, 0, -2); //borramos la ultima coma ","
        //ahora seguimos, concatemos el values 
        $consulta .= ") values(";
        //concatenamos los valores a insertar
        for ($index = 0; $index < count($valorsInput); $index++) {
            $consulta .= "'" . $valorsInput[$index] . "', ";
        }

        $consulta = substr($consulta, 0, -2); //borramos la ultima coma ","
        $consulta .= ")";


        $ejecutar = $this->conex->prepare($consulta);
        if ($ejecutar->execute() === true) {
            return true;
        }
//        INSERT INTO MyGuests (firstname, lastname, email)
//VALUES ('John', 'Doe', 'john@example.com')
    }

    /**
     * eliminado la fila que haya seleccionado,
     * para ello debemos recibir el nombre de la tabla, el id y el campo
     * con el coincide
     * @param string $key
     * @param string $nameTable
     * @param string $id
     * @return boolean
     */
    public function eliminarFila(string $key, string $nameTable, string $id) {
        $consulta = $this->conex->prepare("delete from $nameTable where $key='$id'");
        if ($consulta->execute() === true) {
            return true;
        } else {
            return false;
        }
    }

    //setters and getters
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
