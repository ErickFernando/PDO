<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();
//$nombreBD = $_GET['ndb'];
//$host = $_GET['host'];
//$user = $_GET['user'];
//$pwd = $_GET['pwd'];

$nombreBD = $_GET['ndb'];
$host = $_SESSION['host'];
$user = $_SESSION['user'];
$pwd = $_SESSION['pwd'];


$bd = new ConexionPDO($host, $user, $pwd, $nombreBD);
$bd->conectar();

$tablas = $bd->muestraTablas();
$nombresTalbas = [];
if ($tablas != null) {
    foreach ($tablas as $key => $value) {
        $nombresTalbas[] = $value['Tables_in_' . $nombreBD];
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>TABLAS BD</title>
    </head>
    <body>
        <fieldset >
            <legend>Selecciona tablas <?php echo "$nombreBD"; ?> </legend>
            <form action="tablas.php" method="POST">
                <?php
                foreach ($nombresTalbas as $value) {
                    echo "<input type='button' value=$value>  ";
                }
                ?>

            </form>
            <form style="float: right;" action="index.php" method="POST"><input type="submit" name="volver" value="volver"></form>
        </fieldset>
    </body>
</html>