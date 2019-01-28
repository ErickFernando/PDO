<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();

$nombreBD = $_SESSION['ndb'];

$_SESSION['ndb'] = $nombreBD;


$bd = new ConexionPDO($_SESSION['conexion'], $nombreBD);
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
         <link rel="stylesheet" type="text/css" href="estilos.css">
    </head>
    <body>
        <fieldset style="width: 30%">
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