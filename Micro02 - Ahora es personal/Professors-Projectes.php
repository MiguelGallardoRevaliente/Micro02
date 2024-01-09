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
                    <label style="gap: 40px;" for="">Modul</label>
                    <input type="text">
                </div>
                <form method="post">
                    <button id="crear" name="crear">Crear</button>
                </form>
            </div>
            <div class="l-2">

                <div class="escollir">
                    <div class="b-skills">
                        <p>Skills</p>

                        <button onclick="mostrarskills()" id="escollir" name="escollir">Escollir</button>

                    </div>
                    <div class="b-alumnes">
                        <p>Alumnes</p>

                        <button id="escollir" name="escollir">Escollir</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="skills">
        <h3>ESCOLLIR SKILLS</h3>
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
                <br>
                <div>
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