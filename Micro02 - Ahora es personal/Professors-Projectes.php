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
                $sql = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
                $id_res = mysqli_query($conn, $sql);
                while ($fila = mysqli_fetch_assoc($id_res)) {
                    $id = $fila['id_professor'];
                    $sql = "SELECT CONCAT(nom, ' ', cognoms) FROM professors where id_professor = $id";
                    $nom = mysqli_query($conn, $sql);
                    foreach ($nom as $string) {
                        $valor = implode($string);
                        echo "<button id='user' name='professor'>" . $valor . "</button>";
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
    <div class="header">
        <h1>CHAMOUS</h1>
        <h2>Pàgina de gestió i de creació d’aptituts i intruitats escolars.</h2>
    </div>
    <div class="Professors_Projectes">
        <div class="intro">
            <h2>PROJECTES</h2>
        </div>
        <div class="formulari">
            <div class="l-1">
                <form method="post">
                    <!-- Esto hay que ajustar el css -->
                    <div>
                        <label for="">Nom</label>
                        <input type="text" name="nom" required>
                    </div>
                    <div>
                        <label style="gap: 40px;" for="">Modul</label>
                        <input type="text" name="modul" required>
                    </div>
                    <div>
                        <button id="crear" name="crear">Crear</button>
                    </div>
                </form>
            </div>
            <div class="l-2">

                <div class="escollir">
                    <div class="b-skills">
                        <p>Skills</p>

                        <button onclick="mostrarSkills()" id="escollir" name="escollir">Escollir</button>

                    </div>
                    <div class="b-alumnes">
                        <p>Alumnes</p>

                        <button onclick="mostrarEstudiants()" id="escollir" name="escollir">Escollir</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="projectes">
        <?php
        $sql_id_professor = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
        $id_res = mysqli_query($conn, $sql_id_professor);
        while ($fila = mysqli_fetch_assoc($id_res)) {
            $id = $fila['id_professor'];
            $sql_id_projectes = "SELECT id_projecte FROM professors_projectes WHERE id_professor = $id";
            $id_res_2 = mysqli_query($conn, $sql_id_projectes);
            while ($fila = mysqli_fetch_array($id_res_2)) {
                $id_projecte = $fila['id_projecte'];
                $sql = "SELECT nom, modul FROM projectes WHERE id_projecte = $id_projecte";
                $id_res_3 = mysqli_query($conn, $sql);
                while ($fila = mysqli_fetch_array($id_res_3)) {
                    echo "<div class='projecte'>";
                    echo "<button onclick='mostrarActivitats()'";
                    echo "<span>" . $fila['modul'] . "  -  </span>";
                    echo "<span>" . $fila['nom'] . "</span>";
                    echo "</button>";
                    echo "</div>";
                    echo "<div class='planaactivitats'>";
                    echo "<p>"."</p>";
                    echo "</div>";

                }
            }
        }
        ?>
    </div>
    <div id="escollirSkills">
        <h3>ESCOLLIR SKILLS</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="pre-creacion">

                <div class="creacion">
                    <?php
                    //Hay que ponerlo bonito
                    $sql = "SELECT nom FROM skills";
                    $id_res = mysqli_query($conn, $sql);
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        echo "<div class='skill'>";
                        echo "<input type='checkbox' name='skills[]' value='" . $fila['nom'] . "'>";
                        echo "<label for=''>" . $fila['nom'] . "</label>";
                        echo "<input type='number' name='percentatge[]' min='0' max='100' value='0'>";
                        echo "<label for=''>%</label>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <div>
                    <button name="crearSkills">CREAR</button>
                    <button name="escollir">ESCOLLIR</button>
                </div>
            </div>
        </form>
    </div>
    <?php
    $skills = array();
    $percentatge = array();
    if (isset($_POST['escollir'])) {
        $skills = $_POST['skills'];
        $percentatge = $_POST['percentatge'];
        $suma_percentatge = array_sum($percentatge);
        if ($suma_percentatge != 100) {
            echo "<script>alert('La suma dels percentatges ha de ser 100')</script>";
            echo "<script>escollirSkills.style.display = 'block'</script>";
        }
    }
    if (isset($_POST['crearSkills'])) {
        ?>
        <div id="crearSkills">
            <h3>CREAR SKILLS</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="creando">
                    <div class="nom">
                        <label for="">Nom</label>
                        <input type="text" name="nom" id="nom" required>
                    </div>
                    <div class="tipus">
                        <label for="">Tipus</label>
                        <select name="tipus" id="tipus">
                            <option value="Hard">Hard</option>
                            <option value="Soft">Soft</option>
                        </select>
                    </div>
                    <div class="icona">
                        <label for="foto">Icona</label>
                        <input type="file" name="foto" accept="image/*" required>
                    </div>
                    <div class="creando-button">
                        <button name="creacio">CREAR</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }
    if (isset($_POST['creacio'])) {
        include "connexio.php";
        $nom = $_POST['nom'];
        $tipus = $_POST['tipus'];
        $file = $_FILES['foto'];
        $tipo_foto = $file['type'];
        $tmp_name = $file['tmp_name'];

        // Leer el contenido del archivo
        $dadesImatge = file_get_contents($tmp_name);
        $dadesImatge = addslashes($dadesImatge);
        $sql = "INSERT INTO skills (icona, tipus_foto, nom, tipus) VALUES ('$dadesImatge', '$tipo_foto', '$nom', '$tipus')";
        mysqli_query($conn, $sql);
    }

    //Aqui es donde se crean los proyectos
    if (isset($_POST['crear'])) {
        include "connexio.php";
        $nom = $_POST['nom'];
        $modul = $_POST['modul'];
        $sql = "INSERT INTO projectes (nom, modul) VALUES ('$nom', '$modul')";
        mysqli_query($conn, $sql);
        //Aqui se vincula el profesor con los proyectos creados por él
        $sql = "SELECT id_projecte FROM projectes WHERE nom = '$nom' AND modul = '$modul'";
        $id_projecte = mysqli_query($conn, $sql);
        foreach ($id_projecte as $string) {
            $valor = implode($string);
            $id_projecte = $valor;
            for ($i = 0; $i < count($skills); $i++) {
                $sql_id_skill = "SELECT id_skill FROM skills WHERE nom = '$skills[$i]'";
                $id_skill = mysqli_query($conn, $sql_id_skill);
                foreach ($id_skill as $string) {
                    $valor = implode($string);
                    $id_skill = $valor;
                    $sql = "INSERT INTO skills_projectes (id_projecte, id_skill, percentatge) VALUES ($id_projecte, $id_skill, $percentatge[$i])";
                    mysqli_query($conn, $sql);
                }
            }
            $sql_id = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
            $id_res_professor = mysqli_query($conn, $sql_id);
            while ($fila = mysqli_fetch_assoc($id_res_professor)) {
                $id = $fila['id_professor'];
                $sql = "INSERT INTO professors_projectes (id_professor, id_projecte) VALUES ($id, $id_projecte)";
                mysqli_query($conn, $sql);
            }
        }
    }
    ?>

    <div class="skillsCreadas">
        <h2>SKILLS</h2>
        <div class="skill-general">
            <?php
            $sql = "SELECT nom, icona, tipus_foto, tipus FROM skills";
            $id_res = mysqli_query($conn, $sql);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                echo "<div class='skill'>";
                echo "<img src='data:" . $fila['tipus_foto'] . ";base64," . base64_encode($fila['icona']) . "' alt=''>";
                echo "<br>";
                echo "<br>";
                echo "<label for=''>" . $fila['nom'] . "</label>";
                echo "<br>";
                echo "<br>";
                echo "<label for=''>" . $fila['tipus'] . "</label>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <div id="escollir-alumnes">
        <h3>ESCOLLIR ESTUDIANTS</h3>
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
    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
    <script src="js/professores.js"></script>

</body>

</html>