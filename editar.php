<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();
//$nombreBD = $_GET['ndb'];
//$host = $_GET['host'];
//$user = $_GET['user'];
//$pwd = $_GET['pwd'];

$_ndb = $_SESSION['ndb'];
$host = $_SESSION['host'];
$user = $_SESSION['user'];
$pwd = $_SESSION['pwd'];
$_nombTabla =$_SESSION['nomTabla'];


$bd = new ConexionBD($host, $user, $user, $ndb);
$bd->conectar();

echo "Bienvenido a editar  $_nombTabla";
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Editar Tabla</title>
    </head>
    <body>

    </body>
</html>

