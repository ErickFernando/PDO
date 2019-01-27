<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();
$id = $_SESSION['id'];
$nomTabs = $_SESSION['nomTab'];



$conexion = $_SESSION['conexion'];
$nombreBD = $_SESSION['ndb'];
$key = $_SESSION['key'];

$bd = new ConexionPDO($conexion, $nombreBD);
$bd->conectar();

echo "  $key, $nomTabs, $id";

$asd = $bd->buscaValor($key, $nomTabs, $id);

if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case 'guardar':


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
    </head>
    <body>
        <fieldset style="width: 30%">
            <legend>Editando tabla <?php echo "$nomTabs"; ?></legend>
            <form action="registroTabla.php" method="POST">
                <?php
                foreach ($asd as $key => $value) {
                    echo "<label>$key</label><input type='text' name='valor1' value='$value'><br/>";
                }
                ?> 
                <input type="submit" name='submit' value="guardar">
                <input type="submit" name='submit' value="cancelar">
            </form>
        </fieldset>
    </body>
</html>
