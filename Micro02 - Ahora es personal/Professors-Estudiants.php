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
            <img style="border-radius: 50%; width: 100px;" src="img/logo.png" alt="">
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
        <?php
        if (isset($_POST['home'])) {
            header("Location: indexP.php");
        }
        ?>
    </header>
    <div class="header">
        <h1>CHAMOUS</h1>
        <h2>Pàgina de gestió i de creació d’aptituts i intruitats escolars.</h2>
    </div>
    <div class="Professors_Estudiants">
        <div class="intro">
            <h2>ESTUDIANTS</h2>
        </div>
        <div class="estudiantes">
            <div class="eleccion">
                <h1>Estudiants</h1>
                <?php
                include "connexio.php";

                $sql = "SELECT id_alumne, CONCAT(nom, ' ', cognoms) FROM alumnes";
                $id_res = mysqli_query($conn, $sql);
                ?>
                <form id="botons" method="post">
                    <div>
                    <select name="id_alumne">
                        <?php
                        foreach ($id_res as $string) {
                            $valor = implode($string);
                            $id = substr($valor, 0, 1);
                            $nomCognoms = substr($valor, 1);
                            echo "<option value='$id'>$nomCognoms</option>";
                        }
                        ?>
                    </select>
                    </div>
                    
                    <div class="botones">
                        <button id="mostrar" name="mostrar">Mostrar</button>
                        <button type="button" id="crear" onclick="mostrarCrear()" name="crear">Crear</button>
                        <button id="btn-modificar" name="modificar">Modificar</button>
                        <button id="borrar" name="borrar">Borrar</button>
                        <button type="button" class="importar" id="importar" name="importar">Importar</button>
                    </div>
                </form>
            </div>
            
        </div>
        <div class="estudiant">
            <?php
            if (isset($_POST['mostrar'])) {
                $id_alumne = $_POST['id_alumne'];
                $sql = "SELECT * FROM alumnes WHERE id_alumne = $id_alumne";
                $id_res = mysqli_query($conn, $sql);
                while ($fila = mysqli_fetch_assoc($id_res)) {
                    echo "<div class='estudiant-info'>";
                    echo "<img src='data:" . $fila["tipus_foto"] . ";base64," . base64_encode($fila["foto_perfil"]) . "' alt='''>";
                    echo "<div class='estudiant-valores'>";
                    echo "<p>NOM: " . $fila["nom"] . "</p><br>";
                    echo "<p>COGNOMS: " . $fila["cognoms"] . "</p><br>";
                    echo "<p>CURS: " . $fila["curs"] . "</p><br>";
                    echo "<p>DATA NAIXEMENT: " . $fila["data_naixement"] . "</p><br>";
                    echo "<p>USUARI: " . $fila["usuari"] . "</p><br>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
        </div>

    </div>
    <div id="prueba">
        <h3>CREAR ESTUDIANTS</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="creacion">
                <div>
                    <label for="nom">NOM</label>
                    <input type="text" name="nom" required>
                </div>
                <br>
                <div>
                    <label for="cognoms">COGNOMS</label>
                    <input type="text" name="cognoms" required>
                </div>
                <br>
                <div>
                    <label for="curs">CURS</label>
                    <input type="text" name="curs" required>
                </div>
                <br>
                <div>
                    <label for="naixement">DATA NAIXEMENT</label>
                    <input type="date" name="naixement" required>
                </div>
                <br>
                <div>
                    <label for="foto">FOTO DE PERFIL</label>
                    <input type="file" name="foto" accept="image/*" required>
                </div>
            </div>
            <br><br>
            <div class="boton">
                <button id="crear" name="crear">CREAR</button>
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['crear'])) {
        $nom = $_POST['nom'];
        $cognoms = $_POST['cognoms'];
        $usuari = strtolower(substr($_POST['nom'], 0, 2) . substr($_POST['cognoms'], 0, 2)) . rand(0, 1000);
        $contrasenya = strtolower(substr($_POST['nom'], 0, 2) . substr($_POST['cognoms'], 0, 2)) . rand(0, 1000);
        $curs = $_POST['curs'];
        $naixement = $_POST['naixement'];
        $file = $_FILES['foto'];
        $tipo = $file['type'];
        $tmp_name = $file['tmp_name'];

        // Leer el contenido del archivo
        $dadesImatge = file_get_contents($tmp_name);
        $dadesImatge = addslashes($dadesImatge);
        $sql = "INSERT INTO alumnes (nom, cognoms, usuari, contrasenya, data_naixement, curs, foto_perfil, tipus_foto) VALUES ('$nom', '$cognoms', '$usuari', '$contrasenya',  '$naixement', '$curs', '$dadesImatge', '$tipo')";
        mysqli_query($conn, $sql);
        header("Location: Professors-Estudiants.php");
    }
    ?>

    <?php
    if (isset($_POST['modificar'])) {
        $id_alumne = $_POST['id_alumne'];
        $sql = "SELECT * FROM alumnes WHERE id_alumne = $id_alumne";
        $id_res = mysqli_query($conn, $sql);
        while ($fila = mysqli_fetch_assoc($id_res)) {
            ?>
            <div id="modificar">
                <h3>MODIFICAR ESTUDIANT</h3>
                <form method="post" enctype="multipart/form-data">
                    <div class="creacion">
                        <div>
                            <label for="nom">NOM</label>
                            <input type="text" name="nom" value="<?php echo $fila["nom"] ?>">
                        </div>
                        <br>
                        <div>
                            <label for="cognoms">COGNOMS</label>
                            <input type="text" name="cognoms" value="<?php echo $fila["cognoms"] ?>">
                        </div>
                        <br>
                        <div>
                            <label for="curs">CURS</label>
                            <input type="text" name="curs" value="<?php echo $fila["curs"] ?>">
                        </div>
                        <br>
                        <div>
                            <label for="naixement">DATA NAIXEMENT</label>
                            <input type="date" name="naixement" value="<?php echo $fila["data_naixement"] ?>">
                        </div>
                        <br>
                        <div>
                            <label for="foto">FOTO DE PERFIL</label>
                            <input type="file" name="foto" accept="image/*">
                        </div>
                    </div>
                    <br><br>
                    <div class="boton">
                        <button id="crear" name="modificarAlumne">MODIFICAR</button>
                    </div>
                    <input type="hidden" name="id_alumne" value="<?php echo $id_alumne ?>">
                </form>
            </div>
            <?php
        }
    }

    if (isset($_POST['modificarAlumne'])) {
        $id_alumne = $_POST['id_alumne'];
        $nom = $_POST['nom'];
        $cognoms = $_POST['cognoms'];
        $curs = $_POST['curs'];
        $naixement = $_POST['naixement'];
        if (isset($_FILES['foto']) && !empty($_FILES['foto']['tmp_name'])) {
            $file = $_FILES['foto'];
            $tipo = $file['type'];
            $tmp_name = $file['tmp_name'];

            $dadesImatge = file_get_contents($tmp_name);
            $dadesImatge = addslashes($dadesImatge);
            $sql = "UPDATE alumnes SET nom = '$nom', cognoms = '$cognoms', curs = '$curs', data_naixement = '$naixement', foto_perfil = '$dadesImatge', tipus_foto = '$tipo' WHERE id_alumne = $id_alumne";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE alumnes SET nom = '$nom', cognoms = '$cognoms', curs = '$curs', data_naixement = '$naixement' WHERE id_alumne = $id_alumne";
            mysqli_query($conn, $sql);
        }
    }

    if (isset($_POST['borrar'])) {
        $id_alumne = $_POST['id_alumne'];
        $sql = "DELETE FROM alumnes WHERE id_alumne = $id_alumne";
        mysqli_query($conn, $sql);
    }
    ?>

    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
    <script src="js/professores.js"></script>
</body>

</html>