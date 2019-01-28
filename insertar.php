<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();
$nombTabla = $_SESSION['nombTab'];
$key = [];
$key = $_SESSION['key'];

$bd = new ConexionPDO($_SESSION['conexion'], $_SESSION['ndb']);
$bd->conectar();


$campos = $bd->buscaValor2($nombTabla);
$msj = "";
if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case 'guardar':
            $datosAC = [];
            $datosAC = $_POST['valor1'];
            $ok = $bd->insert($key, $nombTabla, $datosAC);
            if ($ok) {
                $msj = "Se ha incertado una nueva fila";
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
                foreach ($campos as $key => $value) {
                    echo "<label>$key</label><input type='text' name='valor1[]' value=><br/>";
                }
                ?> 
                <input type="submit" name='submit' value="guardar">
                <input type="submit" name='submit' value="cancelar">
            </form>
        </fieldset>
    </body>
</html>

