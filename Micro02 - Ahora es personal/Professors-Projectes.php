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
            $sql = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
            $id_res = mysqli_query($conn, $sql);
            while($fila = mysqli_fetch_array($id_res)){
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
    ?>
    <?php
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
                    <div style="display: flex; gap: 47px;">
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

                        <button id="escollir" name="escollir">Escollir</button>

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
            $id_res = mysqli_query($conn, $sql_id_projectes);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $id_projecte = $fila['id_projecte'];
                $sql = "SELECT nom, modul FROM projectes WHERE id_projecte = $id_projecte";
                $id_res = mysqli_query($conn, $sql);
                while ($fila = mysqli_fetch_assoc($id_res)) {
                    echo "<div class='projecte'>";
                    echo "<p>" . $fila['nom'] . "</p>";
                    echo "<p>" . $fila['modul'] . "</p>";
                    //Aqui va la flechita para el desplegable
                    echo "</div>";
                }
            }
        }
        ?>
    </div>
    <div id="escollirSkills">
        <h3>ESCOLLIR SKILLS</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="creacion">
                <div>
                    <button name="crearSkills">CREAR</button>
                </div>
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
                <div>
                    <button type="button" name="escollir">ESCOLLIR</button>
                </div>
            </div>
        </form>
    </div>
    <?php
    if(isset($_POST['crearSkills'])){
    ?>
        <div id="crearSkills">
            <h3>CREAR SKILLS</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="creacion">
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
                    <div>
                        <label for="foto">Icona</label>
                        <input type="file" name="foto" accept="image/*" required>
                    </div>
                    <div>
                        <button name="creacio">CREAR</button>
                    </div>
                </div>
            </form>
        </div>
    <?php
    }
    if(isset($_POST['creacio'])){
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
    if(isset($_POST['crear'])){
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
            $sql_id= "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
            $id_res = mysqli_query($conn, $sql_id);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $id = $fila['id_professor'];
                $sql = "INSERT INTO professors_projectes (id_professor, id_projecte) VALUES ($id, $id_projecte)";
                mysqli_query($conn, $sql);
            }
        }
    }
    ?>
    <div class="skillsCreadas">
        <h2>SKILLS</h2>
        <?php
        $sql = "SELECT nom, icona, tipus_foto, tipus FROM skills";
        $id_res = mysqli_query($conn, $sql);
        while ($fila = mysqli_fetch_assoc($id_res)) {
            echo "<div class='skill'>";
            echo "<img src='data:" . $fila['tipus_foto'] . ";base64," . base64_encode($fila['icona']) . "' alt=''>";
            echo "<br>";
            echo "<label for=''>" . $fila['nom'] . "</label>";
            echo "<br>";
            echo "<label for=''>" . $fila['tipus'] . "</label>";
            echo "</div>";
        }
        ?>
    </div>
    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
<script src="js/professores.js"></script>

</body>

</html>