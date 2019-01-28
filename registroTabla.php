<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();
$id = $_SESSION['id'];
$nomTabs = $_SESSION['nomTab'];

$key = [];
$key = $_SESSION['key'];

$bd = new ConexionPDO($_SESSION['conexion'], $_SESSION['ndb']);
$bd->conectar();

$valores = $bd->buscaValor($key[0], $nomTabs, $id);
$msj = "";
if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case 'guardar':
            echo "guardar";
            $datosAC = [];
            $datosAC = $_POST['valor1'];

            if ($bd->update($key, $nomTabs, $id, $datosAC)) {
                header("Location:editar.php");
                exit();
            } else {
                $msj = "Error actualizando, ten encuenta las relaciones de integridad referencial  ";
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
        <title>Regristro tabla</title>
        <link rel="stylesheet" type="text/css" href="estilos.css">
    </head>
    <body>
        <header><h1><?php echo "$msj"; ?></h1></header>
        <fieldset style="width: 30%">
            <legend>Editando tabla <?php echo "$nomTabs"; ?></legend>
            <form action="registroTabla.php" method="POST">
                <?php
                foreach ($valores as $key => $value) {
                    echo "<label>$key</label><input type='text' name='valor1[]' value='$value'><br/>";
                }
                ?> 
                <input type="submit" name='submit' value="guardar">
                <input type="submit" name='submit' value="cancelar">
            </form>
        </fieldset>
    </body>
</html>
