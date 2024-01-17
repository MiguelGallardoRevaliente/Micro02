<!-- FILEPATH: /C:/Users/marcz/Desktop/assignatures/DAW2/Projecte/Micro02 - Ahora es personal/index.html -->

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <?php
    include "connexio.php";
    $sql = "SELECT id_usuari_actiu_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
    $id_res = mysqli_query($conn, $sql);
    if (!empty($id_res)) {
        $sql = "DELETE FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
        mysqli_query($conn, $sql);
    }
    $sql = "SELECT id_usuari_actiu_alumne FROM usuari_actiu_alumne WHERE id_usuari_actiu_alumne = 0";
    $id_res = mysqli_query($conn, $sql);
    if (!empty($id_res)) {
        $sql = "DELETE FROM usuari_actiu_alumne WHERE id_usuari_actiu_alumne = 0";
        mysqli_query($conn, $sql);
    }
    function validar()
    {
        include "connexio.php";
        $sql = "SELECT CONCAT(id_professor, ',', usuari, ',', contrasenya) FROM professors";
        $login = mysqli_query($conn, $sql);
        foreach ($login as $string) {
            $valor = implode($string);
            $valor = explode(",", $valor);
            $valor[1] == filter_var($valor[1], FILTER_SANITIZE_STRING);
            $valor[2] == filter_var($valor[2], FILTER_SANITIZE_STRING);
            if ($valor[1] == $_POST['username'] && $valor[2] == $_POST['password']) {
                $sql = "INSERT INTO usuari_actiu_professor (id_professor) VALUES ($valor[0])";
                mysqli_query($conn, $sql);
                header("Location: indexP.php");
            } else {
                echo "<script>alert('Usuario o contraseña incorrectos')</script>";
            }
        }
        $sql = "SELECT CONCAT(id_alumne, ',', usuari, ',', contrasenya) FROM alumnes";
        $login = mysqli_query($conn, $sql);
        foreach ($login as $string) {
            $valor = implode($string);
            $valor = explode(",", $valor);
            $valor[1] == filter_var($valor[1], FILTER_SANITIZE_STRING);
            $valor[2] == filter_var($valor[2], FILTER_SANITIZE_STRING);
            if ($valor[1] == $_POST['username'] && $valor[2] == $_POST['password']) {
                $sql = "INSERT INTO usuari_actiu_alumne (id_alumne) VALUES ($valor[0])";
                mysqli_query($conn, $sql);
                header("Location: indexA.php");
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