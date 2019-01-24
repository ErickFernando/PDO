<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});
session_start();
$d = null;
$muestraR = false;

if (isset($_POST['submit'])) {

    //switch ($_POST['submit']) {
    //  case 'conectar':
    $host = $_POST['host'];
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];
    $bd = new ConexionPDO($host, $user, $pwd);
    $nomBD = $bd->muestraBD();
    if ($nomBD != null) {

        foreach ($nomBD as $key => $value) {
            $d[] = $value['Database'];
        }
        $muestraR = true;
    }
    $_SESSION['host']=$host;
    $_SESSION['pwd']=$pwd;
    $_SESSION['user']=$user;

    //    break;
    //case 'ver_data_base':
//            $radiBD = $_POST['nBD'];
//
//            $_SESSION['host'] = $host;
//            $_SESSION['bd'] = $radiBD;
//            $_SESSION['user'] = $user;
//            $_SESSION['pwd'] = $pwd;
//            echo "$host $user $pwd";
//            header("Location:tablas.php");
//            exit();
    //          break;
//}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset>
            <legend>Conexión</legend>
            <form action="index.php" method="POST">
                <label>Host</label>
                <input type="text" name="host"><br/>
                <label>User</label>
                <input type="text" name="user"><br/>
                <label>Password</label>
                <input type="password" name="pwd"><br/>            
                <input type="submit" name="submit" value="conectar"><br/>
            </form>

            <?php
            if ($muestraR) {
//                echo "<form action='index.php' method='POST'>";
                foreach ($d as $ndb) {

//                    echo "<a href='tablas.php?ndb=$ndb&host=$host&user=$user&pwd=$pwd'>$ndb</a><br/>";
                    echo "<a href='tablas.php?ndb=$ndb'>$ndb</a><br/>";
//                    echo "<input type='radio' name='nBD' value='$ndb'>$ndb<br/>";
                }
//                echo "<input type='submit' name='submit' value='ver_data_base'><br/>";
//                echo "</form>";
            }
            ?>
        </fieldset>
    </body>
</html>
