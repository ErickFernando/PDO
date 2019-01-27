<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();


$_ndb = $_SESSION['ndb'];
$conexion = $_SESSION['conexion'];

$_nombTabla = $_SESSION['tabla'];


$bd = new ConexionPDO($conexion, $_ndb);
$bd->conectar();

$campos = $bd->muestraCampos($_nombTabla);
$posiciones = [];
var_dump($campos[0]);
$_SESSION['key'] = $campos[0];
$rows = $bd->muestraVlores($_nombTabla);

if (isset($_POST['fila'])) {
    echo "asdasd";
    $_SESSION['id'] = $_POST['valor1'];
    $_SESSION['nomTab'] = $_POST['valor2'];

    header("Location:registroTabla.php");
    exit();
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
//                    echo "</td><td><a href='registroTabla.php?id=$f[0] & nomTab=$_nombTabla'>Editar</a></td><td>editar</td><tr/>";
                    echo "</td><td><form action='editar.php' method='POST'><input type='hidden' name='valor1' value='$f[0]'>"
                    . "<input type='hidden' name='valor2' value='$_nombTabla'>"
                    . "<input type='submit' name='fila' value='editar'></form>"
                    . "</td><td>editar</td><tr/>";
                }
                echo "    </tbody>";
                ?>

            </table>
    </body>
</html>

