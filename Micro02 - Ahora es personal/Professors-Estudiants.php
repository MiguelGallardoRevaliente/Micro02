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
                <form method="post">
                    <select>

                    </select>
                </form>
            </div>
            <div class="botones">
                <button id="crear" onclick="mostrarCrear()" name="crear">Crear</button>
                <button id="modificar" name="modificar">Modificar</button>
                <button id="borrar" name="borrar">Borrar</button>
                <button class="importar" id="importar" name="importar">Importar</button>
            </div>
            
        </div>
        <div class="estudiant"></div>

    </div>
        <div id="prueba">
            <h3>CREAR ESTUDIANTS</h3>
            <form method="post" enctype="multipart/form-data">
                <div>
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