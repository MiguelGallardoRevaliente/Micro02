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
                while($fila = mysqli_fetch_assoc($id_res)){
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

    <div class="all">
        <div class="estudiants">
            <div class="text">
                <h1>Gestio de estudiants</h1>
                <p>Clicar para poder crear estudiants, el seu nom, correu entre altres...</p>
            </div>
            <div class="button">
                <form method="post">
                    <button id="estudiantsbtn" name="estudiantsbtn">Estudiants</button>
                </form>
            </div>
        </div>
        <?php
        if (isset($_POST['estudiantsbtn'])) {
            header("Location: Professors-Estudiants.php");
        }
        ?>
        <div class="professors">
            <div class="text">
                <h1>Gestio de Projectes</h1>
                <p>Crea projectes amb les seves skills y les seves activitats per a poder avaluarles.</p>
            </div>
            <div class="button">
                <form method="post">
                    <button id="projectesbtn" name="projectesbtn">Projectes</button>
                </form>
            </div>
        </div>
        <?php
        if (isset($_POST['projectesbtn'])) {
            header("Location: Professors-Projectes.php");
        }
        ?>
    </div>
    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
</body>
</html>
