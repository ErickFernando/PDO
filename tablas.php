<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();

$nombreBD = $_SESSION['ndb'];
$conexion = $_SESSION['conexion'];
$_SESSION['ndb'] = $nombreBD;


$bd = new ConexionPDO($conexion, $nombreBD);
$bd->conectar();
  
$tablas = $bd->muestraTablas();
$nombresTalbas = [];
if ($tablas != null) {
    foreach ($tablas as $key => $value) {
        $nombresTalbas[] = $value['Tables_in_' . $nombreBD];
    }
}

if (isset($_POST['tabla'])) {
    $_SESSION['tabla'] = $_POST['tabla'];
    header("Location:editar.php");
    exit();
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
                    echo "<input type='submit' value=$value name='tabla'>  ";
                }
                ?>

            </form>
            <form style="float: right;" action="index.php" method="POST">
                <input type="submit" name="volver" value="volver"></form>
        </fieldset>
    </body>
</html>