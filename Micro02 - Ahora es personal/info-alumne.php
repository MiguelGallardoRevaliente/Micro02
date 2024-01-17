<?php
include "connexio.php";

if (isset($_POST['home'])) {
    header("Location: indexA.php");
}

if (isset($_POST['alumne'])) {
    header("Location: info-alumne.php");
}

if (isset($_POST['logout'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webpage</title>
    <link rel="stylesheet" href="css/alumnes.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header class="initial">
        <div class="logo">
            <img style="border-radius: 50%; width: 100px;" src="img/logo.png" alt="">
            <h1>ALUMNES</h1>
        </div>
        <nav>
            <form method="post">
                <button id="home" name="home">Home</button>
                <?php
                include "connexio.php";
                $sql = "SELECT id_alumne FROM usuari_actiu_alumne WHERE id_usuari_actiu_alumne = 0";
                $id_res = mysqli_query($conn, $sql);
                while ($fila = mysqli_fetch_assoc($id_res)) {
                    $id = $fila['id_alumne'];
                    $sql = "SELECT CONCAT(nom, ' ', cognoms) FROM alumnes where id_alumne = $id";
                    $nom = mysqli_query($conn, $sql);
                    foreach ($nom as $string) {
                        $valor = implode($string);
                        echo "<button id='user' name='professor'>" . $valor . "</button>";
                    }
                }
                ?>
            </form>
        </nav>
    </header>

    <?php
    if (isset($_POST['canviFotoPerfil'])) {
        if (isset($_FILES['foto']) && !empty($_FILES['foto']['tmp_name'])) {
            $file = $_FILES['foto'];
            $tipo = $file['type'];
            $tmp_name = $file['tmp_name'];

            $dadesImatge = file_get_contents($tmp_name);
            $dadesImatge = addslashes($dadesImatge);
            $sql = "SELECT id_alumne FROM usuari_actiu_alumne WHERE id_usuari_actiu_alumne = 0";
            $id_res = mysqli_query($conn, $sql);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $id_alumne = $fila['id_alumne'];
                $sql = "UPDATE alumnes SET foto_perfil = '$dadesImatge', tipus_foto = '$tipo' WHERE id_alumne = $id_alumne";
                mysqli_query($conn, $sql);
            }
        } else {
            echo "<script>alert('No has seleccionat cap foto')</script>";
        }
    }
    ?>

    <div class="info">
        <div class="alumne">
            <?php
            $sql = "SELECT id_alumne FROM usuari_actiu_alumne WHERE id_usuari_actiu_alumne = 0";
            $id_res = mysqli_query($conn, $sql);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $id_alumne = $fila['id_alumne'];
                $sql_alumne = "SELECT * FROM alumnes WHERE id_alumne = $id_alumne";
                $id_res2 = mysqli_query($conn, $sql_alumne);
                while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                    echo "<img src='data:" . $fila2["tipus_foto"] . ";base64," . base64_encode($fila2["foto_perfil"]) . "' alt='''>";
                    echo "<p>" . $fila2["nom"] . $fila2["cognoms"] . "</p>";
                    echo "<p>" . $fila2["curs"] . "</p>";
                    echo "<p>" . $fila2["data_naixement"] . "</p>";
                    echo "<p>Usuari: " . $fila2["usuari"] . "</p>";
                    echo "<p>Contrasenya: " . $fila2["contrasenya"] . "</p>";
                }
            }

            if (isset($_POST['canviFoto'])) {
                echo "<form class='canvifoto' method='post' enctype='multipart/form-data'>";
                echo "<input type='file' name='foto'>";
                echo "<br>";
                echo "<button name='canviFotoPerfil'>Canviar</button>";
                echo "</form>";
            }
            ?>

            <form method="post">
                <?php
                if (!isset($_POST['canviFoto'])) {
                    echo "<button name='canviFoto'>Canviar Foto de Perfil</button>";
                }
                ?>
                <button name="logout">Cerrar session</button>
            </form>
        </div>
    </div>

    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            var pos = window.name || 0;
            // Solo establecer la posición de desplazamiento si es diferente de 0
            if (pos !== 0) {
                window.scrollTo(0, pos);
            }

            // Manejar el evento click de los botones del formulario
            $('form').on('click', ':submit', function(event) {
                // Guardar la posición de desplazamiento antes de enviar el formulario
                window.name = self.pageYOffset || (document.documentElement.scrollTop + document.body.scrollTop);

                // Permitir que el formulario se envíe de forma predeterminada
                // Esto es necesario para que los botones del formulario funcionen correctamente
                $(this).closest('form').off('submit').submit();
            });

            // Manejar el evento submit del formulario usando AJAX
            $('form').submit(function(event) {
                // Detener la acción por defecto del formulario
                event.preventDefault();

                // Enviar el formulario mediante AJAX
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(data) {}
                });
            });
        });
    </script>
</body>

</html>