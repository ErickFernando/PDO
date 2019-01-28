<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();

//recuperamos el nombre de la tabla y los nombres de las columnas
$nombTabla = $_SESSION['nombTab'];
$key = [];
$key = $_SESSION['key'];
//conexiones
$bd = new ConexionPDO($_SESSION['conexion'], $_SESSION['nombre_bd']);
$bd->conectar();

//mostramos los campos 
//var_dump($key);
//$campos = $bd->muestraCampos($nombTabla);
//var_dump($campos);
$msj = "";
if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case 'guardar':
            $datosAC = [];
            $datosAC = $_POST['valor1'];
            $ok = $bd->insert($key, $nombTabla, $datosAC);
            if ($ok) {
                header("Location:editar.php");
                exit();
            } else {
                $msj = "Algo ha fallado";
            }
            break;
        case 'cancelar':
            header("Location:editar.php");
            exit();
            break;
        default:
            break;
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Insertar</title>
        <link rel="stylesheet" type="text/css" href="estilos.css">
    </head>
    <body>
        <header><h1><?php echo "$msj"; ?></h1></header>
        <fieldset>
            <legend>Insertar datos en la tabla <?php echo "$nombTabla"; ?></legend>
            <form action="insertar.php" method="POST">
                <?php
                for ($index = 0; $index < count($key); $index++) {
                    echo "<label>$key[$index]</label><input type='text' name='valor1[]' value=><br/>";
                }
                ?> 
                <input type="submit" name='submit' value="guardar">
                <input type="submit" name='submit' value="cancelar">
            </form>
        </fieldset>
    </body>
</html>

