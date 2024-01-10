<?php
// Al principio del archivo, antes de cualquier salida HTML
include "connexio.php";

if (isset($_POST['home'])) {
    header("Location: indexP.php");
    exit(); // Termina el script después de la redirección
}

if (isset($_POST['professor'])) {
    header("Location: info-professors.php");
    exit(); // Termina el script después de la redirección
}

if (isset($_POST['logout'])) {
    header("Location: login.php");
    exit(); // Termina el script después de la redirección
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
                $sql = "SELECT CONCAT(nom, ' ', cognoms) FROM professors where id_professor = 1";
                $nom = mysqli_query($conn, $sql);
                foreach ($nom as $string) {
                    $valor = implode($string);
                    echo "<button id='user' name='professor'>" . $valor . "</button>";
                }
                ?>
            </form>
        </nav>
    </header>

    <div class="info">
                
        <div class="profe">
            <?php
            include "connexio.php";
            if(!isset($_POST['crear'])){
                $sql_id = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
                $id_res = mysqli_query($conn, $sql_id);
                while($fila = mysqli_fetch_assoc($id_res)){
                    $id = $fila['id_professor'];
                    $sql = "SELECT * FROM professors WHERE id_professor = $id";
                    $professor = mysqli_query($conn, $sql);
                    while($fila = mysqli_fetch_assoc($professor)){
                        echo "<img src='data:" . $fila["tipus_foto"] . ";base64," . base64_encode($fila["foto_perfil"]) . "' alt='''>";
                        echo "<p>NOM: " . $fila["nom"] . "</p>";
                        echo "<p>COGNOMS: " . $fila["cognoms"] . "</p>";
                        echo "<p>USUARI: " . $fila["usuari"] . "</p>";
                    }
                    
                }
            }
            ?>
        </div>
        <div class="info-boton">
            <form method="post">
            <div class="crear">
            <form method="post">
                <button id="crear" name="crear">CREAR</button>
            </form>
            <?php
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
                <input type="text" name="contrasenya" id="contrasenya" required>
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
                $cognoms = $_POST['cognoms'];
                $usuari = $_POST['usuari'];
                $contrasenya = $_POST['contrasenya'];
                $file = $_FILES['foto'];
                $tipo = $file['type'];
                $tmp_name = $file['tmp_name'];

                // Leer el contenido del archivo
                $dadesImatge = file_get_contents($tmp_name);
                $dadesImatge = addslashes($dadesImatge);
                $sql = "INSERT INTO professors (nom, cognoms, usuari, contrasenya, foto_perfil, tipus_foto) VALUES ('$nom', '$cognoms', '$usuari', '$contrasenya', '$dadesImatge', '$tipo')";
                mysqli_query($conn, $sql);
            }
            ?>
        </div>
                <button name="logout">Cerrar session</button>

            </form>
        </div>
    </div>

    <footer>
        <p>Derechos de imagen @Chamous</p>

    </footer>
</body>

</html>