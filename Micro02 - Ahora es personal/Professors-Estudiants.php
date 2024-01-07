<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Webpage</title>
  <link rel="stylesheet" href="css/professores.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="js/professores.js">
</head>
<body>
    
    <header class="initial">
        <div class="logo">
            <img style="border-radius: 50%; width: 100px;" src="img/logo.png" alt="">
            <h1>PROFESSORS</h1>
        </div>
        <nav>
        <button id="home" name="home">Home</button>
       
        </nav>
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
                <div class="scroll"></div>
            </div>
            <div class="botones">
            <form method="post">
                    <button id="crear" onclick="mostrarCrear()" name="crear">Crear</button> 
                    <button id="modificar" name="modificar">Modificar</button>
                    <button id="borrar" name="borrar">Borrar</button>
                    <button class="importar" id="importar" name="importar">Importar</button>
                </form>
            </div>
            <?php
        if (isset($_POST['crear'])) {
            header("Location: Professors-Estudiants.php");
        }
        ?>
            
        </div>
        <div class="estudiant"></div>

    </div>
        <div class="prueba">
             CREAR ESTUDIANTS
       
    </div>
    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
</body>
</html>