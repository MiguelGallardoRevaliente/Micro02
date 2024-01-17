<?php
if (isset($_POST['home'])) {
    header("Location: indexA.php");
}
if (isset($_POST['alumne'])) {
    header("Location: info-alumne.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webpage</title>
    <link rel="stylesheet" href="css/alumnes.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                if (mysqli_num_rows($id_res) == 0) {
                    header("Location: login.php");
                } else {
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $id = $fila['id_alumne'];
                        $sql = "SELECT CONCAT(nom, ' ', cognoms) FROM alumnes where id_alumne = $id";
                        $nom = mysqli_query($conn, $sql);
                        foreach ($nom as $string) {
                            $valor = implode($string);
                            echo "<button id='user' name='alumne'>" . $valor . "</button>";
                        }
                    }
                }
                ?>
            </form>
        </nav>
    </header>

    <div class="all">
        <h1>PROJECTES</h1>
        <div class="projectes">
            <form method="post">
                <?php
                $sql_usuari_actiu_alumne = "SELECT * FROM usuari_actiu_alumne WHERE id_usuari_actiu_alumne = 0";
                $id_res = mysqli_query($conn, $sql_usuari_actiu_alumne);

                while ($fila = mysqli_fetch_assoc($id_res)) {
                    $id_alumne = $fila['id_alumne'];

                    $sql_alumnes_projectes = "SELECT * FROM alumnes_projectes WHERE id_alumne = $id_alumne";
                    $id_res2 = mysqli_query($conn, $sql_alumnes_projectes);

                    while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                        $id_projecte = $fila2['id_projecte'];

                        $sql_projecte = "SELECT * FROM projectes WHERE id_projecte = $id_projecte";
                        $id_res3 = mysqli_query($conn, $sql_projecte);

                        while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                            $nom = $fila3['nom'];
                            $modul = $fila3['modul'];
                            $id_projecte_2 = $fila3['id_projecte'];
                            if ($modul < 10) {
                                $modul = "M0" . $modul;
                            } else {
                                $modul = "M" . $modul;
                            }

                            echo "<button id='projecte' name='projecte' value='$id_projecte_2'>" . $modul . " - " . $nom . "</button>";
                            echo "<input type='hidden' name='id_alumne' value='" . $id_alumne . "'>";
                        }
                    }
                }

                ?>
            </form>
        </div>
        <div class="projecte-seleccionat">
            <?php
            if (isset($_POST['projecte'])) {
                $id_projecte = $_POST['projecte'];
                $id_alumne = $_POST['id_alumne'];
                $sql_projecte = "SELECT * FROM projectes WHERE id_projecte = $id_projecte";
                $id_res = mysqli_query($conn, $sql_projecte);
                while ($fila = mysqli_fetch_assoc($id_res)) {
                    $nom = $fila['nom'];
                    $modul = $fila['modul'];
                    if ($modul < 10) {
                        $modul = "M0" . $modul;
                    } else {
                        $modul = "M" . $modul;
                    }
                    echo "<div class='titol-projecte'>";
                    echo "<h1>" . $modul . " - " . $nom . "</h1>";
                    $sql_nota_alumne = "SELECT * FROM alumnes_projectes WHERE id_alumne = $id_alumne AND id_projecte = $id_projecte";
                    $nota_alumne_projecte = mysqli_query($conn, $sql_nota_alumne);
                    while ($nota_alumne = mysqli_fetch_assoc($nota_alumne_projecte)) {
                        $nota = $nota_alumne['nota_projecte'];
                        echo "<h2>Nota  " . $nota . "</h2>";
                    }
                    echo "</div>";
                    echo "<div class='activitats'>";
                    $sql_activitats = "SELECT * FROM activitats WHERE id_projecte = $id_projecte";
                    $id_res2 = mysqli_query($conn, $sql_activitats);
                    while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                        if ($fila2['activa'] == 'T') {
            ?>
                            <div class='activitat'>
                                <form method='post' enctype='multipart/form-data'>
                                    <div class='titol-activitat'>
                                        <h2>Activitat <?php echo $fila2['id_activitat'] . " - " . $fila2['nom'] ?></h2>
                                        <button name='entregar'>Enviar</button>
                                    </div>
                                    <p>Data Entrega: <?php echo $fila2['data_entrega'] ?></p>
                                    <p>Arxiu: <i class='bx bx-download'></i></p>
                                    <p>Entrega: <i class='bx bx-upload'></i></p>
                                    <input type='hidden' name='id_activitat' value='<?php echo $fila2['id_activitat'] ?>'>
                                    <input type='hidden' name='id_alumne' value='<?php echo $id_alumne ?>'>
                                    <?php
                                    $sql_skills_activitat = "SELECT * FROM skills_activitats WHERE id_activitat = " . $fila2['id_activitat'];
                                    $id_res3 = mysqli_query($conn, $sql_skills_activitat);
                                    while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                                        $id_skill_activitat = $fila3['id_skill_activitat'];
                                        $sql_id_alumne = "SELECT * FROM usuari_actiu_alumne WHERE id_usuari_actiu_alumne = 0";
                                        $id_res4 = mysqli_query($conn, $sql_id_alumne);
                                        while ($fila4 = mysqli_fetch_assoc($id_res4)) {
                                            $id_alumne = $fila4['id_alumne'];
                                            $sql_nota_alumne = "SELECT * FROM nota_skill_act_alumne WHERE id_skill_activitat = $id_skill_activitat AND id_alumne = $id_alumne";
                                            $id_res5 = mysqli_query($conn, $sql_nota_alumne);
                                            while ($fila5 = mysqli_fetch_assoc($id_res5)) {
                                                $nota = $fila5['nota'];
                                                echo "<p>Nota: " . $nota . "</p>";
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="skills">
                                        <?php
                                        $sql_skills_activitat = "SELECT * FROM skills_activitats WHERE id_activitat = " . $fila2['id_activitat'];
                                        $id_res3 = mysqli_query($conn, $sql_skills_activitat);
                                        while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                                            $id_skill_projecte = $fila3['id_skill_projecte'];
                                            $sql_skills_projecte = "SELECT * FROM skills_projectes WHERE id_skill_projecte = $id_skill_projecte";
                                            $id_res4 = mysqli_query($conn, $sql_skills_projecte);
                                            while ($fila4 = mysqli_fetch_assoc($id_res4)) {
                                                $id_skill = $fila4['id_skill'];
                                                $sql_skills = "SELECT * FROM skills WHERE id_skill = $id_skill";
                                                $id_res5 = mysqli_query($conn, $sql_skills);
                                                while ($fila5 = mysqli_fetch_assoc($id_res5)) {
                                                    $nom_skill = $fila5['nom'];
                                                    $icona = $fila5['icona'];
                                                    $tipus_foto = $fila5['tipus_foto'];
                                                    echo "<img src='data:" . $tipus_foto . ";base64," . base64_encode($icona) . "' alt=''>";
                                                    echo "<p>" . $nom_skill . "</p>";
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </form>
                            </div>
            <?php
                        }
                    }
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            var pos = window.name || 0;
            // Solo establecer la posición de desplazamiento si es diferente de 0
            if (pos !== 0) {
                window.scrollTo(0, pos);
            }

            // Manejar el evento click de los botones del formulario
            $('form').on('click', ':submit', function(event) {
                // Guardar la posición de desplazamiento antes de enviar el formulario
                window.name = self.pageYOffset || (document.documentElement.scrollTop + document.body.scrollTop);

                // Permitir que el formulario se envíe de forma predeterminada
                // Esto es necesario para que los botones del formulario funcionen correctamente
                $(this).closest('form').off('submit').submit();
            });

            // Manejar el evento submit del formulario usando AJAX
            $('form').submit(function(event) {
                // Detener la acción por defecto del formulario
                event.preventDefault();

                // Enviar el formulario mediante AJAX
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(data) {}
                });
            });
        });
    </script>
</body>

</html>