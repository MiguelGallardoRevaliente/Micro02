<?php
include "connexio.php";

if (isset($_POST['home'])) {
    header("Location: indexP.php");
}

if (isset($_POST['professor'])) {
    header("Location: info-professors.php");
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
    <link rel="stylesheet" href="css/professores.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header class="initial">
        <div class="logo">
            <img src="img/logo.png" alt="">
            <h1>PROFESSORS</h1>
        </div>
        <nav>
            <form method="post">
                <button id="home" name="home">Home</button>
                <?php
                include "connexio.php";
                $sql = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
                $id_res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($id_res) == 0) {
                    header("Location: login.php");
                } else {
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $id = $fila['id_professor'];
                        $sql = "SELECT CONCAT(nom, ' ', cognoms) FROM professors where id_professor = $id";
                        $nom = mysqli_query($conn, $sql);
                        foreach ($nom as $string) {
                            $valor = implode($string);
                            echo "<button id='user' name='professor'>" . $valor . "</button>";
                        }
                    }
                }
                ?>
            </form>
        </nav>
    </header>

    <div class="info">

        <div class="crear" style="display:flex; justify-content: flex-end">
            <h1>INFORMACIO PERSONAL</h1>

        </div>
        <div class="profe">
            <?php
            include "connexio.php";
            if (!isset($_POST['crear'])) {
                $sql_id = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
                $id_res = mysqli_query($conn, $sql_id);
                while ($fila = mysqli_fetch_assoc($id_res)) {
                    $id = $fila['id_professor'];
                    $sql = "SELECT * FROM professors WHERE id_professor = $id";
                    $professor = mysqli_query($conn, $sql);
                    while ($fila = mysqli_fetch_assoc($professor)) {
                        $nom = $fila['nom'];
                        $cognoms = $fila['cognoms'];
                        $usuari = $fila['usuari'];
                        $contrasenya = $fila['contrasenya'];
                        echo "<img src='data:" . $fila["tipus_foto"] . ";base64," . base64_encode($fila["foto_perfil"]) . "' alt='' style='max-width: 400px; border-radius: 500px'>";
                        echo "<p>$nom $cognoms</p>";
                        echo "<p>Usuari: $usuari</p>";
                        echo "<p>contrasenya: $contrasenya</p>";
                    }
                }
            }
            ?>
        </div>
        <div class="info-boton">
            <div class="crear">
                <?php
                if (!isset($_POST['crear'])) {
                ?>
                    <form method="post">
                        <button id="crear" name="crear">CREAR</button>
                    </form>
                <?php
                }
                if (isset($_POST['crear'])) {
                ?>
                    <form method="post" enctype="multipart/form-data">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom" required>
                        <br>
                        <label for="cognoms">Cognoms</label>
                        <input type="text" name="cognoms" id="cognoms" required>
                        <br>
                        <label for="usuari">Usuari</label>
                        <input type="text" name="usuari" id="usuari" required>
                        <br>
                        <label for="contrasenya">Contrasenya</label>
                        <input type="password" name="contrasenya" id="contrasenya" required>
                        <br>
                        <label for="foto">Foto de Perfil</label>
                        <input type="file" name="foto" id="foto" accept="image/*" required>
                        <br><br>
                        <button name="crearProfessor">CREAR</button>
                    </form>
                <?php
                }
                if (isset($_POST['crearProfessor'])) {
                    $nom = $_POST['nom'];
                    $nom = filter_var(strip_tags($nom), FILTER_SANITIZE_STRING);
                    $cognoms = $_POST['cognoms'];
                    $cognoms = filter_var(strip_tags($cognoms), FILTER_SANITIZE_STRING);
                    $usuari = $_POST['usuari'];
                    $usuari = filter_var(strip_tags($usuari), FILTER_SANITIZE_STRING);
                    $contrasenya = $_POST['contrasenya'];
                    $contrasenya = filter_var(strip_tags($contrasenya), FILTER_SANITIZE_STRING);
                    if (isset($_FILES['foto']) && !empty($_FILES['foto']['tmp_name'])) {
                        $file = $_FILES['foto'];
                        $tipo = $file['type'];
                        $tmp_name = $file['tmp_name'];

                        // Leer el contenido del archivo
                        $dadesImatge = file_get_contents($tmp_name);
                        $dadesImatge = addslashes($dadesImatge);
                        $sql = "INSERT INTO professors (nom, cognoms, usuari, contrasenya, foto_perfil, tipus_foto) VALUES ('$nom', '$cognoms', '$usuari', '$contrasenya', '$dadesImatge', '$tipo')";
                        mysqli_query($conn, $sql);
                    } else {
                        echo "<script>alert('No has seleccionat cap foto')</script>";
                    }
                }
                ?>
                <form method="post">
                    <button name="logout">Cerrar session</button>
                </form>
            </div>
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