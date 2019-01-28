<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();

$muestraR = false;

//Si paso parámetros de conexión los leo
$datosConexión = [];


if (isset($_POST['submit'])) {

    //switch ($_POST['submit']) {
    //  case 'conectar':
    if (isset($_POST['conectar'])) {

        //Guardo los datos de conexión en variable de sesión
        $_SESSION['conexion']['host'] = filter_input(INPUT_POST, 'host');
        $_SESSION['conexion']['user'] = filter_input(INPUT_POST, 'usuario');
        $_SESSION['conexion']['pass'] = filter_input(INPUT_POST, 'pass');
    }

    if (isset($_SESSION['conexion'])) {
//Si ya he establecido previamente conexión, recojo los datos de sesión
//Si no contendrán null y la conexión fallará y me informará de ello
        $conexion = $_SESSION['conexion'];
    } else {
        //si no inicializo los valores por defecto
        $_SESSION['conexion']['host'] = 'localhost';
        $_SESSION['conexion']['user'] = 'root';
        $_SESSION['conexion']['pwd'] = 'root';
    }
    $nombres_Database = null;//nombres de todas las bases de datos
    $conexion = $_SESSION['conexion'];
//creo un objeto de conexión con la base de datos
    $bd = new ConexionPDO($conexion);
    //conectamos y recuperamos los nombres de las bases de datos
    $nomBD = $bd->muestraBD();
    //si es distinto de null entra y guardamos en un array
    //los nombres de las bases de datos
    //ojo cada base de datos viene por defecto con el nombre
    //Database en un array asociativo
    if ($nomBD != null) {//$
        foreach ($nomBD as $key => $value) {
            $nombres_Database[] = $value['Database'];
        }
        $muestraR = true;//mostramos las bases de datos
    }
    //recogemos el nombre de la base de datos selecciona y 
    //redirigimos a tablas.php
} if (isset($_POST['nombre_bd'])) {
    $_SESSION['nombre_bd'] = $_POST['nombre_bd'];
    header("Location:tablas.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="estilos.css">
    </head>
    <body>
        <fieldset style="width: 30%">
            <legend>Conexión</legend>
            <form action="index.php" method="POST">
                <label>Host</label>
                <input type="text" name="host"><br/>
                <label>User</label>
                <input type="text" name="user"><br/>
                <label>Password</label>
                <input type="password" name="pwd"><br/>            
                <input type="submit" name="submit" value="conectar"><br/>
            </form>

            <?php
            if ($muestraR) {
                echo "<h2>Elige una base de datos</h2>";
                echo "<form action='index.php' method='POST'>";
                foreach ($nombres_Database as $ndb) {
                    echo "<input type='submit' name='nombre_bd' value='$ndb'><br/>";
                }
                echo "</form>";
            }
            ?>
        </fieldset>
    </body>
</html>
