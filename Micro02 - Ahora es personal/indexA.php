<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Webpage</title>
  <link rel="stylesheet" href="css/alumnes.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                while($fila = mysqli_fetch_array($id_res)){
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
    <div class="header">
        <h1>CHAMOUS</h1>
        <h2>Pàgina de gestió i de creació d’aptituts i intruitats escolars.</h2>
    </div>
    <div class="all">
        <h1>PROJECTES</h1>
    </div>
    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
</body>
</html>
