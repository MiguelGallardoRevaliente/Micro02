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

    
</body>
</html>