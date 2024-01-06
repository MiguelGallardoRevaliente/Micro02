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
            </form>
            <h2>(NombreProfe)</h2>
        </nav>
    </header>
    <div class="header">
        <h1>CHAMOUS</h1>
        <h2>Pàgina de gestió i de creació d’aptituts i intruitats escolars.</h2>
    </div>
    <div class="Professors_Projectes">
        <div class="intro">
            <h2>ESTUDIANTS</h2>
        </div>
        <div class="formulari">
            <div class="l-1">
                <div style="display: flex; gap: 47px;">
                    <label for="">Nom</label>
                    <input type="text">
                </div>
                <div>
                    <label for="">Modul</label>
                    <input type="text">
                </div>
                <form method="post">
                    <button id="crear" name="crear">Crear</button>
                </form>
            </div>
            <div class="l-2">
                <div style="display: flex; align-items: top; gap: 10px;">
                    <label for="">Descripcio</label>
                    <input type="text">
                </div>
                <div class="escollir">
                    <div class="b-skills">
                        <p>Skills</p>
                        <form method="post">
                            <button id="escollir" name="escollir">Escollir</button>
                        </form>
                    </div>
                    <div class="b-alumnes">
                        <p>Alumnes</p>
                        <form method="post">
                            <button id="escollir" name="escollir">Escollir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Derechos de imagen @Chamous</p>
    </footer>
</body>

</html>