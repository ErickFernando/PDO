<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();

//recogemos el nombre de la base de datos seleccionada
$nombreBD = $_SESSION['nombre_bd'];
//$_SESSION['ndb'] = $nombreBD;

//ahora realizamos la conexión con la base datos que hemos elegido
$bd = new ConexionPDO($_SESSION['conexion'], $nombreBD);
$bd->conectar();
//indicamos las tablas existentes en esa base de datos  
$tablas = $bd->muestraTablas();
$nombresTalbas = [];//variable para los nombres de las bases de datos
//si es distinto de null entra y nos recorremos el array con 
//los nombres de las tablas
if ($tablas != null) {
    foreach ($tablas as $key => $value) {
        $nombresTalbas[] = $value['Tables_in_' . $nombreBD];
    }
}
//segun la tabla que hayamos elegido
//redireccionamos a editar.php
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