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
                <?php /*
                include "connexio.php";
                $sql = "SELECT CONCAT(nom, ' ', cognoms) FROM professors where id_professor = 1";
                $nom = mysqli_query($conn, $sql);
                foreach ($nom as $string) {
                    $valor = implode($string);
                    echo "<button id='user' name='professor'>" . $valor . "</button>";
                }*/
                ?>
            </form>
        </nav>
        <?php
        if(isset($_POST['home'])) {
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
                <form method="post">
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
                    <button id="mostrar" name="mostar">Mostrar</button>
                </form>
            </div>

            <div class="botones">
                <button id="crear" onclick="mostrarCrear()" name="crear">Crear</button>
                <button id="btn-modificar" onclick="mostrarmodificar()" name="btn-modificar">Modificar</button>
                <button id="borrar" name="borrar">Borrar</button>
                <button class="importar" id="importar" name="importar">Importar</button>
            </div>
            
        </div>
        <div class="estudiant"></div>

    </div>
        <div id="prueba">
            <h3>CREAR ESTUDIANTS</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="creacion">
                <div>
                <label for="nom">NOM</label>
                <input type="text" name="nom">
                </div>
                <br>
                <div>
                <label for="cognoms">COGNOMS</label>
                <input type="text" name="cognoms">
                </div>
                <br>
                <div>
                <label for="curs">CURS</label>
                <input type="text" name="curs">
                </div>
                <br>
                <div>
                <label for="naixement">DATA NAIXEMENT</label>
                <input type="date" name="naixement">
                </div>
                <br><div>
                <label for="foto">FOTO DE PERFIL</label>
                <input type="file" name="foto" accept="image/*">
                </div>
                </div>
                <br><br>
                <div class="boton">
                <button id="crear" name="crear">CREAR</button>
                </div>
            </form>
        </div>
        <?php
    if(isset($_POST['crear'])) {
        $nom = $_POST['nom'];
        $cognoms = $_POST['cognoms'];
        $usuari = strtolower(substr($_POST['nom'], 0, 2) . substr($_POST['cognoms'], 0, 2)) . rand(0, 100);
        $contrasenya = strtolower(substr($_POST['nom'], 0, 2) . substr($_POST['cognoms'], 0, 2)) . rand(0, 100);
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
        <div id="modificar">
            <h3>MODIFICAR ESTUDIANT</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="creacion">
                <div>
                <label for="nom">NOM</label>
                <input type="text" name="nom">
                </div>
                <br>
                <div>
                <label for="cognoms">COGNOMS</label>
                <input type="text" name="cognoms">
                </div>
                <br>
                <div>
                <label for="curs">CURS</label>
                <input type="text" name="curs">
                </div>
                <br>
                <div>
                <label for="naixement">DATA NAIXEMENT</label>
                <input type="date" name="naixement">
                </div>
                <br><div>
                <label for="foto">FOTO DE PERFIL</label>
                <input type="file" name="foto" accept="image/*">
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