<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();


$_nombTabla = $_SESSION['tabla'];

$bd = new ConexionPDO($_SESSION['conexion'], $_SESSION['ndb']);
$bd->conectar();

$campos = $bd->muestraCampos($_nombTabla);
$posiciones = [];
$_SESSION['key'] = $campos;
$rows = $bd->muestraVlores($_nombTabla);


$msj = "";
if (isset($_POST['submit'])) {

    switch ($_POST['submit']) {
        case 'editar':
            $_SESSION['id'] = $_POST['valor1'];
            $_SESSION['nomTab'] = $_POST['valor2'];
            header("Location:registroTabla.php");
            exit();

            break;
        case 'eliminar':
            $id = $_POST['valor1'];
            $nomTab = $_POST['valor2'];
            $ok = $bd->eliminarFila($campos[0], $nomTab, $id);
            if ($ok) {
                $msj = "Se ha eliminado una fila";
            } else {
                $msj = "Imposible eliminar esa fila, puede que haga referencia a otra tabla.";
            }
            break;
        case 'atras':
            header("Location:tablas.php");
            exit();
            break;

        case 'insertar':
            $_SESSION['nombTab'] = $_nombTabla;
            header("Location:insertar.php");
            exit();
            break;
        default:
            break;
    }
}
//var_dump($filas);
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Editar Tabla</title>
        <!--<link rel="stylesheet" type="text/css" href="estilos.css">-->
        <style>
            fieldset, table{
                width: 75%;
            }

            table td,th,tr {

                border: 1px solid black;
                border-collapse: collapse;
            }
            td, th,tr {
                background:#D1BEBE;
                color: #7A5858;
            }


        </style>
    </head>
    <body>
        <header><h1><?php echo "$msj"; ?></h1></header>
        <fieldset> <legend>DATOS <?php echo "$_nombTabla"; ?></legend>
            <table>
                <?php
                echo " <thead> <tr>";
                foreach ($campos as $value) {
                    echo "<th>$value</th>";
                }
                echo "<th>acciones</th><th>acciones</th </tr> </thead> ";
                echo "<tbody><tr>";

                foreach ($rows as $value => $f) {
                    for ($index = 0; $index < count($f); $index++) {
                        echo "<td>$f[$index]";
                    }
//                    echo "</td><td><a href = 'registroTabla.php?id=$f[0] & nomTab=$_nombTabla'>Editar</a></td><td>editar</td><tr/>";
                    echo "</td><td><form action = 'editar.php' method = 'POST'><input type ='hidden' name ='valor1' value ='$f[0]'>"
                    . " <input type = 'hidden' name = 'valor2' value = '$_nombTabla'>"
                    . " <input type = 'submit' name = 'submit' value = 'editar'></form>"
                    . " </td>"
                    . " <td><form action = 'editar.php' method = 'POST'><input type = 'hidden' name = 'valor1' value = '$f[0]'>"
                    . " <input type = 'hidden' name = 'valor2' value = '$_nombTabla'>"
                    . " <input type = 'submit' name = 'submit' value = 'eliminar'></form></td><tr/>";
                }
                echo " </tbody>";
                ?><form action="editar.php" method="POST" >
                    <input style=" float: bottom" type="submit" name="submit" value="insertar">
                    <input style=" float: bottom" type="submit" name="submit" value="atras">
                </form>

            </table>
    </body>
</html>

