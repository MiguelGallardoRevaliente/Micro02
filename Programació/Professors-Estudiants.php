<!DOCTYPE html>
<html lang="en">
<?php
header('Content-Type: text/html; charset=utf-8');
?>

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
        <?php
        if (isset($_POST['home'])) {
            header("Location: indexP.php");
        }
        if (isset($_POST['professor'])) {
            header("Location: info-professors.php");
        }
        ?>
    </header>
    <div class="Professors_Estudiants">
        <div class="intro">
            <h2>ESTUDIANTS</h2>
        </div>
        <div class="estudiantes">
            <div class="eleccion">
                <h1>Estudiants</h1>
                <?php
                function quitarAcentos($cadena)
                {
                    $acentos = ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ'];
                    $sinAcentos = str_replace($acentos, ['a', 'e', 'i', 'o', 'u', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'U', 'N'], $cadena);
                    return $sinAcentos;
                }

                include "connexio.php";
                if (isset($_POST['crear'])) {
                    $nom = strip_tags($_POST['nom']);
                    $cognoms = strip_tags($_POST['cognoms']);
                    //Esto sirve para quitar caracteres especiales del string
                    $nom = filter_var($nom, FILTER_SANITIZE_STRING);
                    $cognoms = filter_var($cognoms, FILTER_SANITIZE_STRING);
                    $usuari = strtolower(substr(quitarAcentos($_POST['nom']), 0, 2) . substr(quitarAcentos($_POST['cognoms']), 0, 2)) . rand(0, 1000);
                    $contrasenya = strtolower(substr(quitarAcentos($_POST['nom']), 0, 2) . substr(quitarAcentos($_POST['cognoms']), 0, 2)) . rand(0, 1000);
                    $sql_alumnes = "SELECT * FROM alumnes";
                    $id_res = mysqli_query($conn, $sql_alumnes);
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $usuari_alumne = $fila['usuari'];
                        while ($usuari == $usuari_alumne) {
                            $usuari = strtolower(substr(quitarAcentos($_POST['nom']), 0, 2) . substr(quitarAcentos($_POST['cognoms']), 0, 2)) . rand(0, 1000);
                        }
                        $contrasenya_alumne = $fila['contrasenya'];
                        while ($contrasenya == $contrasenya_alumne) {
                            $contrasenya = strtolower(substr(quitarAcentos($_POST['nom']), 0, 2) . substr(quitarAcentos($_POST['cognoms']), 0, 2)) . rand(0, 1000);
                        }
                    }
                    $curs = strip_tags($_POST['curs']);
                    $curs = filter_var($curs, FILTER_SANITIZE_STRING);
                    $naixement = $_POST['naixement'];
                    $file = $_FILES['foto'];
                    $tipo = $file['type'];
                    $tmp_name = $file['tmp_name'];

                    // Leer el contenido del archivo
                    $dadesImatge = file_get_contents($tmp_name);
                    $dadesImatge = addslashes($dadesImatge);
                    $sql = "INSERT INTO alumnes (nom, cognoms, usuari, contrasenya, data_naixement, curs, foto_perfil, tipus_foto) VALUES ('$nom', '$cognoms', '$usuari', '$contrasenya',  '$naixement', '$curs', '$dadesImatge', '$tipo')";
                    mysqli_query($conn, $sql);
                }

                if (isset($_POST['modificarAlumne'])) {
                    $id_alumne = $_POST['id_alumne'];
                    $nom = $_POST['nom'];
                    $cognoms = $_POST['cognoms'];
                    $nom = filter_var($nom, FILTER_SANITIZE_STRING);
                    $cognoms = filter_var($cognoms, FILTER_SANITIZE_STRING);
                    $sql_alumne = "SELECT * FROM alumnes WHERE id_alumne = $id_alumne";
                    $id_res = mysqli_query($conn, $sql_alumne);
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $nom_alumne = $fila['nom'];
                        $cognom_alumne = $fila['cognoms'];
                        if ($nom != $nom_alumne || $cognoms != $cognom_alumne) {
                            $usuari = strtolower(substr(quitarAcentos($_POST['nom']), 0, 2) . substr(quitarAcentos($_POST['cognoms']), 0, 2)) . rand(0, 1000);
                            $contrasenya = strtolower(substr(quitarAcentos($_POST['nom']), 0, 2) . substr(quitarAcentos($_POST['cognoms']), 0, 2)) . rand(0, 1000);
                        } else {
                            $usuari = $fila['usuari'];
                            $contrasenya = $fila['contrasenya'];
                        }
                    }
                    $curs = $_POST['curs'];
                    $curs = filter_var($curs, FILTER_SANITIZE_STRING);
                    $naixement = $_POST['naixement'];
                    $_POST['id_alumne'] = $id_alumne;
                    if (isset($_FILES['foto']) && !empty($_FILES['foto']['tmp_name'])) {
                        $file = $_FILES['foto'];
                        $tipo = $file['type'];
                        $tmp_name = $file['tmp_name'];

                        $dadesImatge = file_get_contents($tmp_name);
                        $dadesImatge = addslashes($dadesImatge);
                        $sql = "UPDATE alumnes SET nom = '$nom', cognoms = '$cognoms', usuari = '$usuari', contrasenya = '$contrasenya', curs = '$curs', data_naixement = '$naixement', foto_perfil = '$dadesImatge', tipus_foto = '$tipo' WHERE id_alumne = $id_alumne";
                        mysqli_query($conn, $sql);
                    } else {
                        $sql = "UPDATE alumnes SET nom = '$nom', cognoms = '$cognoms', usuari = '$usuari', contrasenya = '$contrasenya', curs = '$curs', data_naixement = '$naixement' WHERE id_alumne = $id_alumne";
                        mysqli_query($conn, $sql);
                    }
                }

                if (isset($_POST['borrar'])) {
                    $id_alumne = $_POST['id_alumne'];
                    $_POST['id_alumne'] = $id_alumne;
                    $sql_alumne_projecte = "SELECT id_alumne_projecte FROM alumnes_projectes WHERE id_alumne = $id_alumne";
                    $id_res = mysqli_query($conn, $sql_alumne_projecte);
                    if (!empty($id_res)) {
                        while ($fila = mysqli_fetch_assoc($id_res)) {
                            $id_alumne_projecte = $fila['id_alumne_projecte'];
                            $sql = "DELETE FROM alumnes_projectes WHERE id_alumne_projecte = $id_alumne_projecte";
                            mysqli_query($conn, $sql);
                        }
                    }
                    $sql = "DELETE FROM alumnes WHERE id_alumne = $id_alumne";
                    mysqli_query($conn, $sql);
                }

                if (isset($_POST['importar'])) {
                    $alumnes = file_get_contents("alumnes.csv");
                    $alumnes = explode("\n", $alumnes);
                    foreach ($alumnes as $string) {
                        $valor = explode(",", $string);
                        $sql_alumnes = "SELECT * FROM alumnes";
                        $usuari = "";
                        $contrasenya = "";
                        $id_res = mysqli_query($conn, $sql_alumnes);
                        while ($fila = mysqli_fetch_assoc($id_res)) {
                            $usuari_alumne = $fila['usuari'];
                            $nom = strip_tags($valor[0]);
                            $cognoms = strip_tags($valor[1]);
                            $valor[0] = filter_var($nom, FILTER_SANITIZE_STRING);
                            $valor[1] = filter_var($cognoms, FILTER_SANITIZE_STRING);
                            $usuari = mb_strtolower(substr(quitarAcentos($valor[0]), 0, 2) . substr(quitarAcentos($valor[1]), 0, 2)) . rand(0, 1000);
                            $contrasenya = mb_strtolower(substr(quitarAcentos($valor[0]), 0, 2) . substr(quitarAcentos($valor[1]), 0, 2)) . rand(0, 1000);
                            while ($usuari == $usuari_alumne) {
                                $usuari = mb_strtolower(substr(quitarAcentos($valor[0]), 0, 2) . substr(quitarAcentos($valor[1]), 0, 2)) . rand(0, 1000);
                            }
                            $contrasenya_alumne = $fila['contrasenya'];
                            while ($contrasenya == $contrasenya_alumne) {
                                $contrasenya = mb_strtolower(substr(quitarAcentos($valor[0]), 0, 2) . substr(quitarAcentos($valor[1]), 0, 2)) . rand(0, 1000);
                            }
                        }
                        $sql = "INSERT INTO alumnes (nom, cognoms, usuari, contrasenya, data_naixement, curs) VALUES ('$valor[0]', '$valor[1]', '$usuari', '$contrasenya', '$valor[3]', '$valor[2]')";
                        mysqli_query($conn, $sql);
                    }
                    //ACABAR
                }

                $sql = "SELECT * FROM alumnes";
                $id_res = mysqli_query($conn, $sql);
                ?>
                <form id="botons" method="post">
                    <div>
                        <select name="id_alumne">
                            <?php
                            while ($fila = mysqli_fetch_assoc($id_res)) {
                                $nom = $fila['nom'];
                                $cognoms = $fila['cognoms'];
                                $id = $fila['id_alumne'];
                                $nomCognoms = $nom . " " . $cognoms;
                                if ($_POST['id_alumne'] == $id) {
                                    echo "<option value='$id' selected>$nomCognoms</option>";
                                } else {
                                    echo "<option value='$id'>$nomCognoms</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="botones">
                        <button id="mostrar" name="mostrar">Mostrar</button>
                        <button type="button" id="crear" onclick="mostrarCrear()" name="crear">Crear</button>
                        <button id="btn-modificar" name="modificar">Modificar</button>
                        <button id="borrar" name="borrar">Borrar</button>
                        <button class="importar" id="importar" name="importar">Importar</button>
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
        <button onclick="cerrarCrearAlumnes()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
        <form method="post" enctype="multipart/form-data">
            <div class="estudiants-creacion">
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


    if (isset($_POST['modificar'])) {
        $id_alumne = $_POST['id_alumne'];
        $sql = "SELECT * FROM alumnes WHERE id_alumne = $id_alumne";
        $id_res = mysqli_query($conn, $sql);
        while ($fila = mysqli_fetch_assoc($id_res)) {
    ?>
            <div id="modificar">
                <h3>MODIFICAR ESTUDIANT</h3>
                <button onclick="cerrarModificarAlumnes()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
                <form method="post" enctype="multipart/form-data">
                    <div class="estudiants-creacion">
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
    ?>

    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
    <script src="js/professores.js"></script>
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