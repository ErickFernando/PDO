<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});

if (isset($_POST['submit'])) {
    $host = $_POST['host'];
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];
    $bd = new ConexionPDO($host, $user, $pwd);
    
   
      
    
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
                <input type="submit" name="submit" value="conectar">
            </form>
        </fieldset>
    </body>
</html>
