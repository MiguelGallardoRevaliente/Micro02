<!-- FILEPATH: /C:/Users/marcz/Desktop/assignatures/DAW2/Projecte/Micro02 - Ahora es personal/index.html -->

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<?php
function validar(){
    include "connexio.php";
    $sql = "SELECT CONCAT(usuari, ',', contrasenya) FROM professors";
    $login = mysqli_query($conn, $sql);
    foreach ($login as $string) {
        $valor = implode($string);
        $valor = explode(",", $valor);
        if ($valor[0] == $_POST['username'] && $valor[1] == $_POST['password']) {
            header("Location: indexP.php");
        }
    }
}
?>
<div id="loginl">

    <form method="post">
        <label for="username">NOMBRE</label>
        <input type="text" id="username" name="username" value="" required><br><br>

        <label for="password">CONTRASEÑA</label>
        <input type="password" id="password" name="password" value="" required><br><br>

        <button class="btn" name="loginbtn">LOGIN</button>
    </form>
</div>
<div id="loginr">
</div>
<?php
if (isset($_POST['loginbtn'])) {
    validar();
}
?>
</body>
</html>