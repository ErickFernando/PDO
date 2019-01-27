<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();
$d = null;
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
        $_SESSION['conexion']['host'] = 'localhost';
        $_SESSION['conexion']['user'] = 'root';
        $_SESSION['conexion']['pwd'] = 'root';
    }

    $conexion = $_SESSION['conexion'];
//creo un objeto de conexión con la base de datos
    $bd = new ConexionPDO($conexion);
    $nomBD = $bd->muestraBD();
    if ($nomBD != null) {

        foreach ($nomBD as $key => $value) {
            $d[] = $value['Database'];
        }
        $muestraR = true;
    }
} if (isset($_POST['nombre_bd'])) {
    $_SESSION['ndb'] = $_POST['nombre_bd'];
    header("Location:tablas.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset>
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
    echo "<form action='index.php' method='POST'>";
    foreach ($d as $ndb) {

//                    echo "<a href='tablas.php?ndb=$ndb&host=$host&user=$user&pwd=$pwd'>$ndb</a><br/>";
//                    echo "<a href='tablas.php?ndb=$ndb'>$ndb</a><br/>";
//                    echo "<input type='radio' name='nBD' value='$ndb'>$ndb<br/>";
        echo "<input type='submit' name='nombre_bd' value='$ndb'><br/>";
    }

    echo "</form>";
}
?>
        </fieldset>
    </body>
</html>
