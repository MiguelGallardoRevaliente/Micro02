<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webpage</title>
    <link rel="stylesheet" href="css/professores.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                if (mysqli_num_rows($id_res) == 0) {
                    header("Location: login.php");
                } else {
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $id = $fila['id_professor'];
                        $sql = "SELECT CONCAT(nom, ' ', cognoms) FROM professors where id_professor = $id";
                        $nom = mysqli_query($conn, $sql);
                        foreach ($nom as $string) {
                            $valor = implode($string);
                            echo "<button id='user' name='professor'>" . $valor . "</button>";
                        }
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

    <div class="Professors_Projectes">
        <div class="intro">
            <h2>PROJECTES</h2>
        </div>
        <?php
        $skills = [];
        $percentatgeSkills = [];
        $id_alumnes = [];
        $skillsActivitats = [];
        $notas = [];
        $id_skills = [];
        //Esto es cuando escoges las skills de cada proyecto
        if (isset($_POST['escollir'])) {
            $skills = $_POST['skills'];
            $percentatge = $_POST['percentatge'];
            foreach ($percentatge as $key => $value) {
                for ($i = 0; $i < count($skills); $i++) {
                    if ($key == $skills[$i]) {
                        array_push($percentatgeSkills, $value);
                    }
                }
            }
            $suma_percentatge = array_sum($percentatgeSkills);

            if ($suma_percentatge != 100) {
                echo "<script>alert('La suma dels percentatges ha de ser 100')</script>";
                echo "<script>escollirSkills.style.display = 'block'</script>";
            }
            if (isset($_POST['alumnes'])) {
                $id_alumnes = unserialize($_POST['alumnes']);
            }
        }

        //Esto es cuando escoges los alumnos de cada proyecto
        if (isset($_POST['escollirAlumnes'])) {
            $id_alumnes = $_POST['alumnes'];
            if (isset($_POST['skills']) && isset($_POST['percentatge'])) {
                $skills = unserialize($_POST['skills']);
                $percentatgeSkills = unserialize($_POST['percentatge']);
            }
        }

        //Esto es cuando creas una skill
        if (isset($_POST['creacio'])) {
            include "connexio.php";
            $nom = $_POST['nom'];
            $nom = filter_var(strip_tags($nom), FILTER_SANITIZE_STRING);
            $contador = 0;
            $sql = "SELECT * FROM skills";
            $id_res = mysqli_query($conn, $sql);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $nom_skill = $fila['nom'];
                if ($nom == $nom_skill) {
                    echo "<script>alert('Ja existeix una skill amb aquest nom')</script>";
                    $contador++;
                }
            }
            if ($contador == 0) {
                $tipus = $_POST['tipus'];
                if (isset($_FILES['foto']) && !empty($_FILES['foto']['tmp_name'])) {
                    $file = $_FILES['foto'];
                    $tipo_foto = $file['type'];
                    $tmp_name = $file['tmp_name'];

                    // Leer el contenido del archivo
                    $dadesImatge = file_get_contents($tmp_name);
                    $dadesImatge = addslashes($dadesImatge);
                    $sql = "INSERT INTO skills (icona, tipus_foto, nom, tipus) VALUES ('$dadesImatge', '$tipo_foto', '$nom', '$tipus')";
                    mysqli_query($conn, $sql);
                } else {
                    echo "<script>alert('No has seleccionat cap foto')</script>";
                }
            }
        }

        //Esto es cuando creas un proyecto
        if (isset($_POST['crear'])) {
            include "connexio.php";
            $nom = $_POST['nom'];
            $nom = filter_var(strip_tags($nom), FILTER_SANITIZE_STRING);
            $modul = $_POST['modul'];
            $skills = unserialize($_POST['skills']);
            $percentatge = unserialize($_POST['percentatge']);
            $id_alumnes = unserialize($_POST['alumnes']);
            $contador = 0;
            $sql_projectes = "SELECT * FROM projectes";
            $id_res = mysqli_query($conn, $sql_projectes);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $nom_projecte = $fila['nom'];
                $modul_projecte = $fila['modul'];
                if ($nom == $nom_projecte && $modul == $modul_projecte) {
                    echo "<script>alert('Ja existeix un projecte amb aquest nom i mòdul')</script>";
                    $contador++;
                } else if ($nom == $nom_projecte) {
                    echo "<script>alert('Ja existeix un projecte amb aquest nom')</script>";
                    $contador++;
                } else if ($modul == $modul_projecte) {
                    echo "<script>alert('Ja existeix un projecte amb aquest mòdul')</script>";
                    $contador++;
                }
            }
            if ($contador == 0) {
                if (empty($skills) && empty($id_alumnes)) {
                    echo "<script>alert('Has de seleccionar com a mínim una skill i un alumne')</script>";
                } else if (empty($skills)) {
                    echo "<script>alert('Has de seleccionar com a mínim una skill')</script>";
                } else if (empty($id_alumnes)) {
                    echo "<script>alert('Has de seleccionar com a mínim un alumne')</script>";
                } else {
                    $sql = "INSERT INTO projectes (nom, modul) VALUES ('$nom', $modul)";
                    mysqli_query($conn, $sql);
                    //Aqui se vincula el profesor con los proyectos creados por él
                    $sql = "SELECT id_projecte FROM projectes WHERE nom = '$nom' AND modul = $modul";
                    $id_projecte = mysqli_query($conn, $sql);
                    foreach ($id_projecte as $string) {
                        $valor = implode($string);
                        $id_projecte = $valor;
                        $nota = 0;
                        for ($i = 0; $i < count($skills); $i++) {
                            $sql_id_skill = "SELECT id_skill FROM skills WHERE nom = '$skills[$i]'";
                            $id_skills = mysqli_query($conn, $sql_id_skill);
                            foreach ($id_skills as $string2) {
                                $valor2 = implode($string2);
                                $id_skill = $valor2;
                                $sql_skill_projecte = "INSERT INTO skills_projectes (id_projecte, id_skill, percentatge) VALUES ($id_projecte, $id_skill, $percentatge[$i])";
                                mysqli_query($conn, $sql_skill_projecte);
                            }
                        }
                        for ($i = 0; $i < count($id_alumnes); $i++) {
                            $sql_alumnes_projecte = "INSERT INTO alumnes_projectes (id_alumne, id_projecte, nota_projecte) VALUES ($id_alumnes[$i], $id_projecte, $nota)";
                            mysqli_query($conn, $sql_alumnes_projecte);
                        }
                        $sql_id = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
                        $id_res_professor = mysqli_query($conn, $sql_id);
                        while ($fila = mysqli_fetch_assoc($id_res_professor)) {
                            $id = $fila['id_professor'];
                            $sql = "INSERT INTO professors_projectes (id_professor, id_projecte) VALUES ($id, $id_projecte)";
                            mysqli_query($conn, $sql);
                        }
                    }
                }
            }
        }

        if (isset($_POST['modificacioProjecte'])) {
            $id_projecte = $_POST['id_projecte'];
            $nom = $_POST['nom'];
            $nom = filter_var(strip_tags($nom), FILTER_SANITIZE_STRING);
            $modul = $_POST['modul'];
            $skills_id = $_POST['id_skill'];
            $skills = $_POST['skills'];
            $percentatge = $_POST['percentatge'];
            $percentatgeSkills = [];
            $id_skills = [];
            foreach ($percentatge as $key => $value) {
                for ($i = 0; $i < count($skills); $i++) {
                    if ($key == $skills[$i]) {
                        array_push($percentatgeSkills, $value);
                        array_push($id_skills, $skills_id[$key]);
                    }
                }
            }
            $alumnes = $_POST['alumnes'];
            $notas_alumnes = [];
            $id_alumnes = [];
            $id_projectes = [];
            $notaProjecte = 0;
            $contador = 0;
            $sql_projectes = "SELECT * FROM projectes";
            $id_res = mysqli_query($conn, $sql_projectes);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $nom_projecte = $fila['nom'];
                $modul_projecte = $fila['modul'];
                if ($nom == $nom_projecte && $modul == $modul_projecte && $id_projecte != $fila['id_projecte']) {
                    echo "<script>alert('Ja existeix un projecte amb aquest nom i mòdul')</script>";
                    $contador++;
                } else if ($nom == $nom_projecte && $id_projecte != $fila['id_projecte']) {
                    echo "<script>alert('Ja existeix un projecte amb aquest nom')</script>";
                    $contador++;
                } else if ($modul == $modul_projecte && $id_projecte != $fila['id_projecte']) {
                    echo "<script>alert('Ja existeix un projecte amb aquest mòdul')</script>";
                    $contador++;
                }
            }
            if ($contador == 0) {
                if (array_sum($percentatgeSkills) != 100) {
                    echo "<script>alert('La suma dels percentatges ha de ser 100')</script>";
                    echo "<script>modificarProjecte.style.display = 'block'</script>";
                } else {
                    $sql_projecte = "UPDATE projectes SET nom = '$nom', modul = $modul WHERE id_projecte = $id_projecte";
                    mysqli_query($conn, $sql_projecte);
                    $sql_skills_projectes = "SELECT * FROM skills_projectes";
                    $id_res = mysqli_query($conn, $sql_skills_projectes);
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $id_skill_projecte = $fila['id_skill_projecte'];
                        for ($i = 0; $i < count($id_skills); $i++) {
                            if ($id_projecte == $fila['id_projecte'] && $id_skills[$i] == $fila['id_skill']) {
                                $sql_skill_projecte = "UPDATE skills_projectes SET percentatge = $percentatgeSkills[$i] WHERE id_skill_projecte = $id_skill_projecte";
                                mysqli_query($conn, $sql_skill_projecte);
                            } else if ($id_projecte != $fila['id_projecte'] && $id_skills[$i] != $fila['id_skill']) {
                                $sql_skill_projecte = "INSERT INTO skills_projectes (id_projecte, id_skill, percentatge) VALUES ($id_projecte, $id_skills[$i], $percentatgeSkills[$i])";
                                mysqli_query($conn, $sql_skill_projecte);
                            }
                        }
                    }
                    $sql_alumnes_projecte_delete = "DELETE FROM alumnes_projectes WHERE id_projecte = $id_projecte";
                    mysqli_query($conn, $sql_alumnes_projecte_delete);
                    for ($i = 0; $i < count($alumnes); $i++) {
                        $sql_skills_projectes = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                        $id_res = mysqli_query($conn, $sql_skills_projectes);
                        while ($fila = mysqli_fetch_assoc($id_res)) {
                            $id_skill_projecte = $fila['id_skill_projecte'];
                            $percentatge = $fila['percentatge'];
                            $notaSkill = 0;
                            $sql_skills_activitats = "SELECT * FROM skills_activitats WHERE id_skill_projecte = $id_skill_projecte";
                            $id_res2 = mysqli_query($conn, $sql_skills_activitats);
                            while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                $id_skill_activitat = $fila2['id_skill_activitat'];
                                $sql = "SELECT * FROM nota_skill_act_alumne WHERE id_skill_activitat = $id_skill_activitat AND id_alumne = $alumnes[$i]";
                                $id_res3 = mysqli_query($conn, $sql);
                                while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                                    $nota = $fila3['nota'];
                                    $id_alumne = $fila3['id_alumne'];
                                    array_push($id_alumnes, $id_alumne);
                                    $notaSkill = $nota * $percentatge / 100;
                                    $notaProjecte = $notaProjecte + $notaSkill;
                                    echo "<br>";
                                    echo $notaProjecte;
                                    echo "<br>";
                                }
                            }
                        }
                        $sql_alumnes_projecte = "INSERT INTO alumnes_projectes (nota_projecte, id_alumne, id_projecte) VALUES (0, $alumnes[$i], $id_projecte)";
                        mysqli_query($conn, $sql_alumnes_projecte);
                        for ($j = 0; $j < count($id_alumnes); $j++) {
                            if ($alumnes[$i] == $id_alumnes[$j]) {
                                $sql_alumnes_projecte = "UPDATE alumnes_projectes SET nota_projecte = $notaProjecte WHERE id_alumne = $alumnes[$i] AND id_projecte = $id_projecte";
                                mysqli_query($conn, $sql_alumnes_projecte);
                            }
                        }
                    }
                }
            }
        }

        if (isset($_POST['borrarDefinitiuProjecte'])) {
            $id_projecte = $_POST['id_projecte'];
            $sql_professors_projecte = "DELETE FROM professors_projectes WHERE id_projecte = $id_projecte";
            mysqli_query($conn, $sql_professors_projecte);
            $sql_alumnes_projecte = "DELETE FROM alumnes_projectes WHERE id_projecte = $id_projecte";
            mysqli_query($conn, $sql_alumnes_projecte);
            $sql_skills_projectes = "SELECT id_skill_projecte FROM skills_projectes WHERE id_projecte = $id_projecte";
            $id_res = mysqli_query($conn, $sql_skills_projectes);
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $id_skill_projecte = $fila['id_skill_projecte'];
                $sql_skills_activitats = "SELECT id_skill_activitat FROM skills_activitats WHERE id_skill_projecte = $id_skill_projecte";
                $id_res2 = mysqli_query($conn, $sql_skills_activitats);
                while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                    $id_skill_activitat = $fila2['id_skill_activitat'];
                    $sql_delete_notas = "DELETE FROM nota_skill_act_alumne WHERE id_skill_activitat = $id_skill_activitat";
                    mysqli_query($conn, $sql_delete_notas);
                }
                $sql_delete_skills_activitats = "DELETE FROM skills_activitats WHERE id_skill_projecte = $id_skill_projecte";
                mysqli_query($conn, $sql_delete_skills_activitats);
            }
            $sql_delete_skills_projectes = "DELETE FROM skills_projectes WHERE id_projecte = $id_projecte";
            mysqli_query($conn, $sql_delete_skills_projectes);
            $sql_delete_projecte = "DELETE FROM projectes WHERE id_projecte = $id_projecte";
            mysqli_query($conn, $sql_delete_projecte);
        }

        //Esto es cuando modificas una skill
        if (isset($_POST['modificarSkill'])) {
            $id_skill = $_POST['id_skill'];
            $nom = $_POST['nom'];
            $nom = filter_var(strip_tags($nom), FILTER_SANITIZE_STRING);
            $tipus = $_POST['tipus'];
            if (isset($_FILES['foto']) && !empty($_FILES['foto']['tmp_name'])) {
                $file = $_FILES['foto'];
                $tipo = $file['type'];
                $tmp_name = $file['tmp_name'];

                $dadesImatge = file_get_contents($tmp_name);
                $dadesImatge = addslashes($dadesImatge);
                $sql_update_foto = "UPDATE skills SET icona = '$dadesImatge', tipus_foto = '$tipo', nom = '$nom', tipus = '$tipus' WHERE id_skill = $id_skill";
                mysqli_query($conn, $sql_update_foto);
            } else {
                $sql_update = "UPDATE skills SET nom = '$nom', tipus = '$tipus' WHERE id_skill = $id_skill";
                mysqli_query($conn, $sql_update);
            }
        }

        //Esto es cuando borras una skill
        if (isset($_POST['borrarSkill'])) {
            $id_skill = $_POST['id_skill'];
            $sql_skill_projectes = "SELECT id_skill_projecte FROM skills_projectes WHERE id_skill = $id_skill";
            $id_res = mysqli_query($conn, $sql_skill_projectes);
            if (!empty($id_res)) {
                //Aqui se borra de la tabla que vincula skills y proyectos
                while ($fila = mysqli_fetch_assoc($id_res)) {
                    $id_skill_projecte = $fila['id_skill_projecte'];
                    echo "<br>";
                    echo $id_skill_projecte;
                    echo "<br>";
                    $sql_skill_activitats = "SELECT * FROM skills_activitats WHERE id_skill_projecte = $id_skill_projecte";
                    $id_res2 = mysqli_query($conn, $sql_skill_activitats);
                    if (!empty($id_res2)) {
                        while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                            $id_skill_activitat = $fila2['id_skill_activitat'];
                            $id_activitat = $fila2['id_activitat'];
                            $sql_delete_notas = "DELETE FROM nota_skill_act_alumne WHERE id_skill_activitat = $id_skill_activitat";
                            mysqli_query($conn, $sql_delete_notas);
                            $sql_delete_skill_activitat = "DELETE FROM skills_activitats WHERE id_skill_activitat = $id_skill_activitat AND id_activitat = $id_activitat";
                            mysqli_query($conn, $sql_delete_skill_activitat);
                            $sql_delete_activitat = "DELETE FROM activitats WHERE id_activitat = $id_activitat";
                            mysqli_query($conn, $sql_delete_activitat);
                        }
                    }
                    $sql_delete_skill_projecte = "DELETE FROM skills_projectes WHERE id_skill_projecte = $id_skill_projecte";
                    mysqli_query($conn, $sql_delete_skill_projecte);
                }
            }
            $sql = "DELETE FROM skills WHERE id_skill = $id_skill";
            mysqli_query($conn, $sql);
        }

        //Esto es cuando creas una actividad
        if (isset($_POST['crearActivitats'])) {
            $llargada = $_POST['llargada'];
            for ($i = 0; $i < $llargada; $i++) {
                $skill = $_POST["skill"];
                $nomActivitat = $_POST['nom'];
                $nomActivitat = filter_var(strip_tags($nomActivitat), FILTER_SANITIZE_STRING);
                $id_projecte = $_POST['id_projecte'];
                $activa = $_POST['activa'];
                $contador = 0;
                $dataEntrega = $_POST['dataentrega'];
                $dataSystem = date('Y-m-d');
                if (strtotime($dataEntrega) <= strtotime($dataSystem)) {
                    echo "<script>alert('La fecha de entrega no puede ser igual o anterior a la fecha actual')</script>";
                } else {
                    $sql_activitat = "SELECT * FROM activitats";
                    $id_res = mysqli_query($conn, $sql_activitat);
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $nom_activitat = $fila['nom'];
                        if ($nom_activitat == $nomActivitat) {
                            $contador++;
                        }
                    }
                    if ($contador == 0) {
                        $sql = "INSERT INTO activitats (nom, data_entrega, activa, id_projecte) VALUES ('$nomActivitat', '$dataEntrega', '$activa', $id_projecte)";
                        mysqli_query($conn, $sql);
                        $sql_id_activitat = "SELECT id_activitat FROM activitats WHERE nom = '$nomActivitat' AND data_entrega = '$dataEntrega' AND id_projecte = $id_projecte";
                        $id_activitat = mysqli_query($conn, $sql_id_activitat);
                        foreach ($id_activitat as $string) {
                            $valor = implode($string);
                            $id_activitat = $valor;
                            $sql_id_skill = "SELECT id_skill FROM skills WHERE nom = '$skill'";
                            $id_res = mysqli_query($conn, $sql_id_skill);
                            while ($fila = mysqli_fetch_assoc($id_res)) {
                                $id_skill = $fila['id_skill'];
                                $sql_skill_projecte = "SELECT id_skill_projecte FROM skills_projectes WHERE id_projecte = $id_projecte AND id_skill = $id_skill";
                                $id_res2 = mysqli_query($conn, $sql_skill_projecte);
                                while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                    $id_skill_projecte = $fila2['id_skill_projecte'];
                                    $sql_skill_activitat = "INSERT INTO skills_activitats (id_activitat, id_skill_projecte) VALUES ($id_activitat, $id_skill_projecte)";
                                    mysqli_query($conn, $sql_skill_activitat);
                                }
                            }
                        }
                    }
                }
            }
        }

        //Esto es cuando modificas una actividad
        if (isset($_POST['modificacioActivitats'])) {
            $llargada = $_POST['llargada'];
            for ($i = 0; $i < $llargada; $i++) {
                $hola = "skill" . $i;
                $skill = $_POST[$hola];
                $nomActivitat = $_POST['nom'];
                $nomActivitat = filter_var(strip_tags($nomActivitat), FILTER_SANITIZE_STRING);
                $dataEntrega = $_POST['dataentrega'];
                $dataEntrega = $_POST['dataentrega'];
                $dataSystem = date('Y-m-d');
                if (strtotime($dataEntrega) <= strtotime($dataSystem)) {
                    echo "<script>alert('La fecha de entrega no puede ser igual o anterior a la fecha actual')</script>";
                } else {
                    $id_activitat = $_POST['id_activitat'];
                    $id_projecte = $_POST['id_projecte'];
                    $mostrarActivitats = "mostrarActivitats" . $id_projecte;
                    $_POST[$mostrarActivitats] = "";
                    $activa = $_POST['activa'];
                    $contador = 0;
                    $sql_activitat = "SELECT * FROM activitats";
                    $id_res = mysqli_query($conn, $sql_activitat);
                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $nom_activitat = $fila['nom'];
                        if ($nom_activitat == $nomActivitat) {
                            echo "<script>alert('Ja existeix una activitat amb aquest nom')</script>";
                            $contador++;
                        }
                    }
                    if ($contador == 0) {
                        $borrarSkillActivitat = 0;
                        $sql = "UPDATE activitats SET nom = '$nomActivitat', data_entrega = '$dataEntrega', activa = '$activa' WHERE id_activitat = $id_activitat";
                        mysqli_query($conn, $sql);
                        $sql_id_activitat = "SELECT id_activitat FROM activitats WHERE nom = '$nomActivitat' AND data_entrega = '$dataEntrega' AND id_projecte = $id_projecte";
                        $id_activitat = mysqli_query($conn, $sql_id_activitat);
                        foreach ($id_activitat as $string) {
                            $valor = implode($string);
                            $id_activitat = $valor;
                            $sql_id_skill = "SELECT id_skill FROM skills WHERE nom = '$skill'";
                            $id_res = mysqli_query($conn, $sql_id_skill);
                            while ($fila = mysqli_fetch_assoc($id_res)) {
                                $id_skill = $fila['id_skill'];
                                $sql_skill_projecte = "SELECT id_skill_projecte FROM skills_projectes WHERE id_projecte = $id_projecte AND id_skill = $id_skill";
                                $id_res2 = mysqli_query($conn, $sql_skill_projecte);
                                while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                    $id_skill_projecte = $fila2['id_skill_projecte'];
                                    mysqli_query($conn, 'SET foreign_key_checks = 0');
                                    if ($borrarSkillActivitat == 0) {
                                        $sql_delete_skill_activitat = "DELETE FROM skills_activitats WHERE id_activitat = $id_activitat";
                                        mysqli_query($conn, $sql_delete_skill_activitat);
                                        $borrarSkillActivitat++;
                                    }
                                    mysqli_query($conn, 'SET foreign_key_checks = 1');
                                    $sql_skill_activitat = "INSERT INTO skills_activitats (id_activitat, id_skill_projecte) VALUES ($id_activitat, $id_skill_projecte)";
                                    mysqli_query($conn, $sql_skill_activitat);
                                }
                            }
                        }
                    }
                }
            }
        }
        //Esto es cuando borras una actividad
        if (isset($_POST['borrarDefinitiuActivitiat'])) {
            $id_activitat = $_POST['id_activitat'];

            $sql_skill_activitats = "SELECT * FROM skills_activitats WHERE id_activitat = $id_activitat";
            $id_res = mysqli_query($conn, $sql_skill_activitats);

            if (!empty($id_res)) {
                while ($fila = mysqli_fetch_assoc($id_res)) {
                    $id_skill_activitat = $fila['id_skill_activitat'];
                    $id_skill_projecte = $fila['id_skill_projecte'];

                    $sql_nota_activitat = "SELECT * FROM nota_skill_act_alumne WHERE id_skill_activitat = $id_skill_activitat";
                    $id_res2 = mysqli_query($conn, $sql_nota_activitat);

                    while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                        $notaAlumne = $fila2['nota'];
                        $id_alumne = $fila2['id_alumne'];

                        $sql_skill_projecte = "SELECT * FROM skills_projectes WHERE id_skill_projecte = $id_skill_projecte";
                        $id_res3 = mysqli_query($conn, $sql_skill_projecte);

                        while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                            $id_projecte = $fila3['id_projecte'];
                            $percentatge = $fila3['percentatge'];

                            $sql_alumne_projecte = "SELECT * FROM alumnes_projectes WHERE id_alumne = $id_alumne AND id_projecte = $id_projecte";
                            $id_res4 = mysqli_query($conn, $sql_alumne_projecte);

                            while ($fila4 = mysqli_fetch_assoc($id_res4)) {
                                $notaAlumneProjecte = $fila4['nota_projecte'];
                                $notaSkill = $notaAlumne * $percentatge / 100;
                                $notaAlumneProjecte = $notaAlumneProjecte - $notaSkill;

                                // Actualizar la nota total del proyecto del alumno
                                $sql_update_nota_alumne = "UPDATE alumnes_projectes SET nota_projecte = $notaAlumneProjecte WHERE id_alumne = $id_alumne AND id_projecte = $id_projecte";
                                mysqli_query($conn, $sql_update_nota_alumne);
                            }
                        }
                    }

                    // Eliminar notas de la actividad
                    $sql_delete_notas = "DELETE FROM nota_skill_act_alumne WHERE id_skill_activitat = $id_skill_activitat";
                    mysqli_query($conn, $sql_delete_notas);

                    // Eliminar la relación entre skills_activitats y activitats
                    $sql_delete_skill_activitat = "DELETE FROM skills_activitats WHERE id_skill_activitat = $id_skill_activitat";
                    mysqli_query($conn, $sql_delete_skill_activitat);
                }
            }

            // Eliminar la actividad
            $sql_delete_actividad = "DELETE FROM activitats WHERE id_activitat = $id_activitat";
            mysqli_query($conn, $sql_delete_actividad);
        }


        //Esto es cuando validas una actividad
        if (isset($_POST['validacioActivitat'])) {
            $id_projecte = $_POST['id_projecte'];
            $id_activitat = $_POST['id_activitat'];
            $id_alumne = $_POST['alumne'];
            $mostrarActivitats = "mostrarActivitats" . $id_projecte;
            $_POST[$mostrarActivitats] = "";
            $nota = $_POST['nota'];
            $sql = "SELECT * FROM skills_activitats WHERE id_activitat = $id_activitat";
            $id_res = mysqli_query($conn, $sql);
            $notaFinal = 0;
            while ($fila = mysqli_fetch_assoc($id_res)) {
                $id_skill_activitat = $fila['id_skill_activitat'];
                $id_skill_projecte = $fila['id_skill_projecte'];
                $sql = "INSERT INTO nota_skill_act_alumne (id_skill_activitat, id_alumne, nota) VALUES ($id_skill_activitat, $id_alumne, $nota)";
                mysqli_query($conn, $sql);
                $sql_skill_projecte = "SELECT * FROM skills_projectes WHERE id_skill_projecte = $id_skill_projecte";
                $id_res2 = mysqli_query($conn, $sql_skill_projecte);
                while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                    $percentatge = $fila2['percentatge'];
                    $id_projecte = $fila2['id_projecte'];
                    $notaSkill = $nota * $percentatge / 100;
                    $notaFinal = $notaFinal + $notaSkill;
                    $sql_insert_nota_projecte = "UPDATE alumnes_projectes SET nota_projecte = $notaFinal WHERE id_alumne = $id_alumne AND id_projecte = $id_projecte";
                    mysqli_query($conn, $sql_insert_nota_projecte);
                }
            }
        }

        $skills_totals = [];
        $id_skills = [];
        $skills_id = [];
        if (isset($_POST['escollirSkillsProjectes'])) {
            $skills = $_POST['skills'];
            $percentatge = $_POST['percentatge'];
            $skills_id = $_POST['id_skill'];
            foreach ($percentatge as $key => $value) {
                for ($i = 0; $i < count($skills); $i++) {
                    if ($key == $skills[$i]) {
                        array_push($percentatgeSkills, $value);
                        array_push($id_skills, $skills_id[$key]);
                    }
                }
            }
            $suma_percentatge = array_sum($percentatgeSkills);
            if ($suma_percentatge != 100) {
                echo "<script>alert('La suma dels percentatges ha de ser 100')</script>";
            } else {
                $id_projecte = $_POST['id_projecte'];
                $percentatge = $_POST['percentatge'];

                $sql_skills_no_projecte = "SELECT * FROM skills";
                $id_res = mysqli_query($conn, $sql_skills_no_projecte);

                while ($fila = mysqli_fetch_assoc($id_res)) {
                    $id_projecte = $_POST['id_projecte'];
                    $percentatge = $_POST['percentatge'];

                    $sql_skills_no_projecte = "SELECT * FROM skills";
                    $id_res = mysqli_query($conn, $sql_skills_no_projecte);

                    while ($fila = mysqli_fetch_assoc($id_res)) {
                        $id_skill = $fila['id_skill'];
                        $nom_skill = $fila['nom'];

                        // Verificar si la skill ya estaba relacionada con el proyecto
                        $sql_check_relation = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte AND id_skill = $id_skill";
                        $check_result = mysqli_query($conn, $sql_check_relation);

                        if ($check_result && mysqli_num_rows($check_result) > 0) {
                            // La skill ya estaba relacionada, actualizar porcentaje
                            $row = mysqli_fetch_assoc($check_result);
                            $id_skill_projecte = $row['id_skill_projecte'];
                            $sql_update = "UPDATE skills_projectes SET percentatge = $percentatge[$nom_skill] WHERE id_skill_projecte = $id_skill_projecte";
                            mysqli_query($conn, $sql_update);

                            // Actualizar nota en alumnes_projectes
                            $sql_update_nota = " UPDATE alumnes_projectes ap INNER JOIN nota_skill_act_alumne nsaa ON ap.id_alumne = nsaa.id_alumne INNER JOIN skills_activitats sa ON nsaa.id_skill_activitat = sa.id_skill_activitat SET ap.nota_projecte = nsaa.nota * $percentatge[$nom_skill] / 100 WHERE ap.id_projecte = $id_projecte AND sa.id_skill_projecte = $id_skill_projecte";
                            mysqli_query($conn, $sql_update_nota);
                        } else {
                            if ($percentatge[$nom_skill] != 0) {
                                $sql_insert = "INSERT INTO skills_projectes (id_projecte, id_skill, percentatge) VALUES ($id_projecte, $id_skill, $percentatge[$nom_skill])";
                                mysqli_query($conn, $sql_insert);
                            }
                        }
                    }
                }
            }
        }
        ?>

        <!---- Este formulario es para crear los proyectos ---->
        <div class="formulari">
            <div class="l-1">
                <form method="post">
                    <!-- Esto hay que ajustar el css -->
                    <div>
                        <label for="">Nom</label>
                        <input type="text" name="nom" required>
                    </div>
                    <div>
                        <label style="gap: 40px;" for="">Modul</label>
                        <input type="number" name="modul" required>
                    </div>
                    <div>
                        <button id="crear" name="crear">Crear</button>
                    </div>
                    <input type="hidden" name="skills" value="<?php echo htmlspecialchars(serialize($skills)); ?>">
                    <input type="hidden" name="percentatge" value="<?php echo htmlspecialchars(serialize($percentatgeSkills)); ?>">
                    <input type="hidden" name="alumnes" value="<?php echo htmlspecialchars(serialize($id_alumnes)); ?>">
                </form>
            </div>
            <!---- Aqui es donde estan los botones para escoger las skills y los alumnos para cada proyecto ---->
            <div class="l-2">

                <div class="escollir">
                    <div class="b-skills">
                        <p>Skills</p>

                        <button onclick="mostrarSkills()" id="escollir" name="escollir">Escollir</button>

                    </div>
                    <div class="b-alumnes">
                        <p>Alumnes</p>

                        <button onclick="mostrarEstudiants()" id="escollir" name="escollir">Escollir</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---- Todo esto es para mostrar los proyectos de cada professor ---->
    <div class="projectes">
        <?php
        $sql_id_professor = "SELECT id_professor FROM usuari_actiu_professor WHERE id_usuari_actiu_professor = 0";
        $id_res = mysqli_query($conn, $sql_id_professor);
        while ($fila = mysqli_fetch_assoc($id_res)) {
            $id = $fila['id_professor'];
            if ($id == 1) {
                $sql_id_projectes = "SELECT id_projecte FROM professors_projectes";
                $id_res_2 = mysqli_query($conn, $sql_id_projectes);
                while ($fila = mysqli_fetch_array($id_res_2)) {
                    $id_projecte = $fila['id_projecte'];
                    $sql = "SELECT * FROM projectes WHERE id_projecte = $id_projecte";
                    $id_res_3 = mysqli_query($conn, $sql);
                    while ($fila = mysqli_fetch_array($id_res_3)) {
                        $mostrarActivitats = "mostrarActivitats" . $id_projecte;
        ?>
                        <div class='projecte' style="display: flex; justify-content: space-between; align-items: center">
                            <div class="nomProjecte">
                                <form method="post">
                                    <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                                    <button name="infoProjecte"><i class='bx bx-info-circle'></i></button>
                                    <?php
                                    if ($fila['modul'] < 10) {
                                        $modul = "M0" . $fila['modul'];
                                    } else {
                                        $modul = "M" . $fila['modul'];
                                    }
                                    ?>
                                    <span><?php echo $modul ?> - </span>
                                    <span><?php echo $fila['nom'] ?></span>
                                    <button name="modificarProjecte"><i class='bx bx-edit-alt'></i></button>
                                    <button name="borrarProjecte"><i class='bx bx-trash'></i></button>
                                </form>
                            </div>
                            <form method="post">
                                <button name="<?php echo $mostrarActivitats ?>"><i class='bx bx-chevron-down'></i></button>
                                <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                            </form>
                        </div>
                        <?php
                        //Esto es cuando quieres mostrar las actividades de cada proyecto
                        if (isset($_POST[$mostrarActivitats]) == $mostrarActivitats) {
                            $sql = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                            $suma_percentatge = 0;
                            $id_res = mysqli_query($conn, $sql);
                            while ($fila = mysqli_fetch_assoc($id_res)) {
                                $percentatge = $fila['percentatge'];
                                $suma_percentatge = $suma_percentatge + $percentatge;
                            }
                            if ($suma_percentatge != 100) {
                                echo "<script>alert(`Has d'afegir o modificar el percentatge de les skills per arribar al 100%`)</script>";
                        ?>
                                <div id="escollirSkills2">
                                    <h3>ESCOLLIR SKILLS</h3>
                                    <button onclick="cerrarEscollirSkills2()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
                                    <form style="display: block; height: auto; margin: 0px" method="post">
                                        <button class="crear-escollir-skills" name="crearSkills">+</button>
                                    </form>
                                    <form method="post">
                                        <div class="pre-creacion">
                                            <div class="creacion">
                                                <?php
                                                $sql = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                                                $id_res = mysqli_query($conn, $sql);

                                                // Obtener las skills relacionadas con el proyecto
                                                $skillsRelacionadas = [];
                                                while ($fila = mysqli_fetch_assoc($id_res)) {
                                                    $id_skill_relacionada = $fila['id_skill'];
                                                    $skillsRelacionadas[$id_skill_relacionada] = $fila['percentatge'];
                                                }

                                                $sql_skill = "SELECT * FROM skills";
                                                $id_res2 = mysqli_query($conn, $sql_skill);

                                                while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                    $nom_skill = $fila2['nom'];
                                                    $tipus_skill = $fila2['tipus'];
                                                    $id_skill = $fila2['id_skill'];

                                                    echo "<div class='skills'>";

                                                    if (array_key_exists($id_skill, $skillsRelacionadas)) {
                                                        // Skill relacionada con el proyecto
                                                        $percentatge = $skillsRelacionadas[$id_skill];
                                                        echo "<input type='hidden' name='skills[]' value='$nom_skill'>";
                                                        echo "<label for=''>$nom_skill</label>";
                                                        echo "<input type='number' name='percentatge[$nom_skill]' min='0' max='100' value='$percentatge'>";
                                                        echo "<label for=''>%</label>";
                                                    } else {
                                                        // Skill no relacionada con el proyecto
                                                        echo "<input type='checkbox' name='skills[]' value='$nom_skill'>";
                                                        echo "<label for=''>$nom_skill</label>";
                                                        echo "<input type='number' name='percentatge[$nom_skill]' min='0' max='100' value='0'>";
                                                        echo "<label for=''>%</label>";
                                                    }

                                                    echo "<input type='hidden' name='id_skill[$nom_skill]' value='$id_skill'>";
                                                    echo "</div>";
                                                }
                                                ?>
                                            </div>
                                            <div>
                                                <input type='hidden' name='id_projecte' value='<?php echo $id_projecte ?>'>
                                                <button name="escollirSkillsProjectes">ESCOLLIR</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class='planaactivitats' transition-style="in:wipe:down">
                                    <div class='activitats-top'>
                                        <h3>ACTIVITATS</h3>
                                        <form method="post">
                                            <button name="creacioActivitats">+</button>
                                            <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                                            <input type="hidden" name="<?php echo $mostrarActivitats ?>" value="<?php echo $mostrarActivitats ?>">
                                        </form>
                                    </div>
                                    <div class='activitats-all'>
                                        <?php
                                        $sql_activitats = "SELECT * FROM activitats WHERE id_projecte = $id_projecte ORDER BY id_activitat";
                                        $id_res_activitats = mysqli_query($conn, $sql_activitats);
                                        $i = 0;
                                        while ($fila_activitat = mysqli_fetch_assoc($id_res_activitats)) {
                                            $nom = $fila_activitat['nom'];
                                            $id_activitat = $fila_activitat['id_activitat'];
                                            $data_entrega = $fila_activitat['data_entrega'];
                                            $activa = $fila_activitat['activa'];
                                            $mActivitat = "mActivitats" . $i;
                                            $validaActivitat = "validaActivitat" . $i;
                                        ?>
                                            <div class='activitats'>
                                                <form method="post">
                                                    <div class='activitats-nom'>
                                                        <button name="<?php echo $mActivitat ?>">
                                                            <i class='bx bx-checkbox-minus'></i>
                                                        </button>
                                                        <span>Activitat <?php echo $id_activitat ?> - </span>
                                                        <span><?php echo $nom ?> - </span>
                                                        <span><?php echo $data_entrega ?> - </span>
                                                        <span>
                                                            <?php
                                                            if ($activa == 'T') {
                                                                echo "Activa";
                                                            } else {
                                                                echo "No Activa";
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <div class='activitats-icons'>
                                                        <button name="modificarActivitat"><i class='bx bx-edit-alt'></i></button>
                                                        <button name="borrarActivitat"><i class='bx bx-trash'></i></button>
                                                        <button name="<?php echo $validaActivitat ?>"><i class='bx bx-check'></i></button>
                                                        <input type="hidden" name="id_activitat" value="<?php echo $id_activitat ?>">
                                                        <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                                                        <input type="hidden" name="<?php echo $mostrarActivitats ?>" value="<?php echo $mostrarActivitats ?>">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="activitat-caracterisitiques">
                                                <?php
                                                if (isset($_POST[$validaActivitat])) {
                                                    echo "<div class='validacio-activitat'>";
                                                    echo "<h3>VALIDACIÓ ACTIVITAT</h3>";
                                                    echo "<form method='post'>";
                                                    echo "<label for=''>Alumne</label>";
                                                    echo "<select name='alumne' id=''>";
                                                    $sql = "SELECT * FROM alumnes_projectes WHERE id_projecte = $id_projecte";
                                                    $id_res = mysqli_query($conn, $sql);
                                                    while ($fila = mysqli_fetch_assoc($id_res)) {
                                                        $id_alumne = $fila['id_alumne'];
                                                        $sql_alumne = "SELECT * FROM alumnes WHERE id_alumne = $id_alumne";
                                                        $id_res2 = mysqli_query($conn, $sql_alumne);
                                                        while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                            $nom_alumne = $fila2['nom'];
                                                            $cognoms_alumne = $fila2['cognoms'];
                                                            echo "<option value='$id_alumne'>$nom_alumne $cognoms_alumne</option>";
                                                        }
                                                    }
                                                    echo "</select>";
                                                    echo "<br>";
                                                    echo "<label for=''>Nota</label>";
                                                    echo "<input type='number' name='nota' id='' required>";
                                                    echo "<button name='validacioActivitat'>Validar</button>";
                                                    echo "<input type='hidden' name='id_activitat' value='$id_activitat'>";
                                                    echo "<input type='hidden' name='id_projecte' value='$id_projecte'>";
                                                    echo "<input type='hidden' name='$mostrarActivitats' value='$mostrarActivitats'>";
                                                    echo "</form>";
                                                    echo "</div>";
                                                }
                                                //Esto es cuando quieres mostrar las skills de cada actividad
                                                if (isset($_POST[$mActivitat])) {
                                                    $id_activitat = $_POST['id_activitat'];
                                                    $sql = "SELECT * FROM skills_activitats WHERE id_activitat = $id_activitat";
                                                    $id_res = mysqli_query($conn, $sql);
                                                    echo "<div class='activitats-skills'>";
                                                    while ($fila = mysqli_fetch_assoc($id_res)) {
                                                        $id_skill_projecte = $fila['id_skill_projecte'];
                                                        $sql_skills_projectes = "SELECT * FROM skills_projectes WHERE id_skill_projecte = $id_skill_projecte";
                                                        $id_res2 = mysqli_query($conn, $sql_skills_projectes);
                                                        while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                            $id_skill = $fila2['id_skill'];
                                                            $sql_skills = "SELECT * FROM skills WHERE id_skill = $id_skill";
                                                            $id_res3 = mysqli_query($conn, $sql_skills);
                                                            while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                                                                $icona = $fila3['icona'];
                                                                $tipus_foto = $fila3['tipus_foto'];
                                                                $nom_skill = $fila3['nom'];
                                                                $tipus = $fila3['tipus'];
                                                ?>
                                                                <div class="skill-imagen">
                                                                    <img src="data:<?php echo $tipus_foto ?>;base64,<?php echo base64_encode($icona) ?>" alt="" title="<?php echo $nom_skill . ' [' . $tipus . ']' ?>">
                                                                    <p><?php echo $nom_skill ?></p>
                                                                </div>
                                    <?php
                                                            }
                                                        }
                                                    }
                                                    echo "</div>";
                                                }
                                                $i++;
                                            }
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    }
                                }
                            }
                        } else {
                            $sql_id_projectes = "SELECT id_projecte FROM professors_projectes WHERE id_professor = $id";
                            $id_res_2 = mysqli_query($conn, $sql_id_projectes);
                            while ($fila = mysqli_fetch_array($id_res_2)) {
                                $id_projecte = $fila['id_projecte'];
                                $sql = "SELECT * FROM projectes WHERE id_projecte = $id_projecte";
                                $id_res_3 = mysqli_query($conn, $sql);
                                while ($fila = mysqli_fetch_array($id_res_3)) {
                                    $mostrarActivitats = "mostrarActivitats" . $id_projecte;
                                    ?>
                                    <div class='projecte' style="display: flex; justify-content: space-between; align-items: center">
                                        <div class="nomProjecte">
                                            <form method="post">
                                                <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                                                <button name="infoProjecte"><i class='bx bx-info-circle'></i></button>
                                                <?php
                                                if ($fila['modul'] < 10) {
                                                    $modul = "M0" . $fila['modul'];
                                                } else {
                                                    $modul = "M" . $fila['modul'];
                                                }
                                                ?>
                                                <span><?php echo $modul ?> - </span>
                                                <span><?php echo $fila['nom'] ?></span>
                                                <button name="modificarProjecte"><i class='bx bx-edit-alt'></i></button>
                                                <button name="borrarProjecte"><i class='bx bx-trash'></i></button>
                                            </form>
                                        </div>
                                        <form method="post">
                                            <button name="<?php echo $mostrarActivitats ?>"><i class='bx bx-chevron-down'></i></button>
                                            <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                                        </form>
                                    </div>
                                    <?php
                                    //Esto es cuando quieres mostrar las actividades de cada proyecto
                                    if (isset($_POST[$mostrarActivitats]) == $mostrarActivitats) {
                                        $sql = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                                        $suma_percentatge = 0;
                                        $id_res = mysqli_query($conn, $sql);
                                        while ($fila = mysqli_fetch_assoc($id_res)) {
                                            $percentatge = $fila['percentatge'];
                                            $suma_percentatge = $suma_percentatge + $percentatge;
                                        }
                                        if ($suma_percentatge != 100) {
                                            echo "<script>alert(`Has d'afegir o modificar el percentatge de les skills per arribar al 100%`)</script>";
                                    ?>
                                            <div id="escollirSkills2">
                                                <h3>ESCOLLIR SKILLS</h3>
                                                <button onclick="cerrarEscollirSkills2()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
                                                <form style="display: block; height: auto; margin: 0px" method="post">
                                                    <button class="crear-escollir-skills" name="crearSkills">+</button>
                                                </form>
                                                <form method="post">
                                                    <div class="pre-creacion">
                                                        <div class="creacion">
                                                            <?php
                                                            $sql = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                                                            $id_res = mysqli_query($conn, $sql);

                                                            // Obtener las skills relacionadas con el proyecto
                                                            $skillsRelacionadas = [];
                                                            while ($fila = mysqli_fetch_assoc($id_res)) {
                                                                $id_skill_relacionada = $fila['id_skill'];
                                                                $skillsRelacionadas[$id_skill_relacionada] = $fila['percentatge'];
                                                            }

                                                            $sql_skill = "SELECT * FROM skills";
                                                            $id_res2 = mysqli_query($conn, $sql_skill);

                                                            while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                                $nom_skill = $fila2['nom'];
                                                                $tipus_skill = $fila2['tipus'];
                                                                $id_skill = $fila2['id_skill'];

                                                                echo "<div class='skills'>";

                                                                if (array_key_exists($id_skill, $skillsRelacionadas)) {
                                                                    // Skill relacionada con el proyecto
                                                                    $percentatge = $skillsRelacionadas[$id_skill];
                                                                    echo "<input type='hidden' name='skills[]' value='$nom_skill'>";
                                                                    echo "<label for=''>$nom_skill</label>";
                                                                    echo "<input type='number' name='percentatge[$nom_skill]' min='0' max='100' value='$percentatge'>";
                                                                    echo "<label for=''>%</label>";
                                                                } else {
                                                                    // Skill no relacionada con el proyecto
                                                                    echo "<input type='checkbox' name='skills[]' value='$nom_skill'>";
                                                                    echo "<label for=''>$nom_skill</label>";
                                                                    echo "<input type='number' name='percentatge[$nom_skill]' min='0' max='100' value='0'>";
                                                                    echo "<label for=''>%</label>";
                                                                }

                                                                echo "<input type='hidden' name='id_skill[$nom_skill]' value='$id_skill'>";
                                                                echo "</div>";
                                                            }
                                                            ?>
                                                        </div>
                                                        <div>
                                                            <input type='hidden' name='id_projecte' value='<?php echo $id_projecte ?>'>
                                                            <button name="escollirSkillsProjectes">ESCOLLIR</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class='planaactivitats' transition-style="in:wipe:down">
                                                <div class='activitats-top'>
                                                    <h3>ACTIVITATS</h3>
                                                    <form method="post">
                                                        <button name="creacioActivitats">+</button>
                                                        <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                                                        <input type="hidden" name="<?php echo $mostrarActivitats ?>" value="<?php echo $mostrarActivitats ?>">
                                                    </form>
                                                </div>
                                                <div class='activitats-all'>
                                                    <?php
                                                    $sql_activitats = "SELECT * FROM activitats WHERE id_projecte = $id_projecte ORDER BY id_activitat";
                                                    $id_res_activitats = mysqli_query($conn, $sql_activitats);
                                                    $i = 0;
                                                    while ($fila_activitat = mysqli_fetch_assoc($id_res_activitats)) {
                                                        $nom = $fila_activitat['nom'];
                                                        $id_activitat = $fila_activitat['id_activitat'];
                                                        $data_entrega = $fila_activitat['data_entrega'];
                                                        $activa = $fila_activitat['activa'];
                                                        $mActivitat = "mActivitats" . $i;
                                                        $validaActivitat = "validaActivitat" . $i;
                                                    ?>
                                                        <div class='activitats'>
                                                            <form method="post">
                                                                <div class='activitats-nom'>
                                                                    <button name="<?php echo $mActivitat ?>">
                                                                        <i class='bx bx-checkbox-minus'></i>
                                                                    </button>
                                                                    <span>Activitat <?php echo $id_activitat ?> - </span>
                                                                    <span><?php echo $nom ?> - </span>
                                                                    <span><?php echo $data_entrega ?> - </span>
                                                                    <span>
                                                                        <?php
                                                                        if ($activa == 'T') {
                                                                            echo "Activa";
                                                                        } else {
                                                                            echo "No Activa";
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                                <div class='activitats-icons'>
                                                                    <button name="modificarActivitat"><i class='bx bx-edit-alt'></i></button>
                                                                    <button name="borrarActivitat"><i class='bx bx-trash'></i></button>
                                                                    <button name="<?php echo $validaActivitat ?>"><i class='bx bx-check'></i></button>
                                                                    <input type="hidden" name="id_activitat" value="<?php echo $id_activitat ?>">
                                                                    <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                                                                    <input type="hidden" name="<?php echo $mostrarActivitats ?>" value="<?php echo $mostrarActivitats ?>">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="activitat-caracterisitiques">
                                                            <?php
                                                            if (isset($_POST[$validaActivitat])) {
                                                                echo "<div class='validacio-activitat'>";
                                                                echo "<h3>VALIDACIÓ ACTIVITAT</h3>";
                                                                echo "<form method='post'>";
                                                                echo "<label for=''>Alumne</label>";
                                                                echo "<select name='alumne' id=''>";
                                                                $sql = "SELECT * FROM alumnes_projectes WHERE id_projecte = $id_projecte";
                                                                $id_res = mysqli_query($conn, $sql);
                                                                while ($fila = mysqli_fetch_assoc($id_res)) {
                                                                    $id_alumne = $fila['id_alumne'];
                                                                    $sql_alumne = "SELECT * FROM alumnes WHERE id_alumne = $id_alumne";
                                                                    $id_res2 = mysqli_query($conn, $sql_alumne);
                                                                    while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                                        $nom_alumne = $fila2['nom'];
                                                                        $cognoms_alumne = $fila2['cognoms'];
                                                                        echo "<option value='$id_alumne'>$nom_alumne $cognoms_alumne</option>";
                                                                    }
                                                                }
                                                                echo "</select>";
                                                                echo "<br>";
                                                                echo "<label for=''>Nota</label>";
                                                                echo "<input type='number' name='nota' id='' required>";
                                                                echo "<button name='validacioActivitat'>Validar</button>";
                                                                echo "<input type='hidden' name='id_activitat' value='$id_activitat'>";
                                                                echo "<input type='hidden' name='id_projecte' value='$id_projecte'>";
                                                                echo "<input type='hidden' name='$mostrarActivitats' value='$mostrarActivitats'>";
                                                                echo "</form>";
                                                                echo "</div>";
                                                            }
                                                            //Esto es cuando quieres mostrar las skills de cada actividad
                                                            if (isset($_POST[$mActivitat])) {
                                                                $id_activitat = $_POST['id_activitat'];
                                                                $sql = "SELECT * FROM skills_activitats WHERE id_activitat = $id_activitat";
                                                                $id_res = mysqli_query($conn, $sql);
                                                                echo "<div class='activitats-skills'>";
                                                                while ($fila = mysqli_fetch_assoc($id_res)) {
                                                                    $id_skill_projecte = $fila['id_skill_projecte'];
                                                                    $sql_skills_projectes = "SELECT * FROM skills_projectes WHERE id_skill_projecte = $id_skill_projecte";
                                                                    $id_res2 = mysqli_query($conn, $sql_skills_projectes);
                                                                    while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                                        $id_skill = $fila2['id_skill'];
                                                                        $sql_skills = "SELECT * FROM skills WHERE id_skill = $id_skill";
                                                                        $id_res3 = mysqli_query($conn, $sql_skills);
                                                                        while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                                                                            $icona = $fila3['icona'];
                                                                            $tipus_foto = $fila3['tipus_foto'];
                                                                            $nom_skill = $fila3['nom'];
                                                                            $tipus = $fila3['tipus'];
                                                            ?>
                                                                            <div class="skill-imagen">
                                                                                <img src="data:<?php echo $tipus_foto ?>;base64,<?php echo base64_encode($icona) ?>" alt="" title="<?php echo $nom_skill . ' [' . $tipus . ']' ?>">
                                                                                <p><?php echo $nom_skill ?></p>
                                                                            </div>
                                    <?php
                                                                        }
                                                                    }
                                                                }
                                                                echo "</div>";
                                                            }
                                                            $i++;
                                                        }
                                                        echo "</div>";
                                                        echo "</div>";
                                                        echo "</div>";
                                                        echo "</div>";
                                                        echo "</div>";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                //Aqui eliges si quieres mostrar skills o alumnos relacionados al proyecto
                                if (isset($_POST['infoProjecte'])) {
                                    $id_projecte = $_POST['id_projecte'];
                                    echo "<div class='info-projecte'>";
                                    echo "<form method='post'>";
                                    echo "<button onclick='cerrarCrearActivitats()' class='cerrar-ventana2'><i class='bx bx-x'></i></button>";
                                    echo "<button name='skillsProjectes'>Skills</button>";
                                    echo "<button name='alumnesProjectes'>Alumnes</button>";
                                    echo "<input type='hidden' name='id_projecte' value='$id_projecte'>";
                                    echo "</form>";
                                    echo "</div>";
                                }

                                //Aqui muestras las skills relacionadas al proyecto
                                if (isset($_POST['skillsProjectes'])) {
                                    $id_projecte = $_POST['id_projecte'];
                                    $sql = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                                    $id_res = mysqli_query($conn, $sql);
                                    ?>
                                    <div class="skills-container">
                                        <button style="margin-top: 7px !important;" onclick='cerrarInfoProjecteSkills()' class='cerrar-ventana'><i class='bx bx-x'></i></button>
                                        <?php
                                        while ($fila = mysqli_fetch_assoc($id_res)) {
                                            $percentatge = $fila['percentatge'];
                                            $id_skill = $fila['id_skill'];
                                            $sql_skill = "SELECT * FROM skills WHERE id_skill = $id_skill";
                                            $id_res2 = mysqli_query($conn, $sql_skill);
                                            while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                $icona = $fila2['icona'];
                                                $tipus_foto = $fila2['tipus_foto'];
                                                $nom_skill = $fila2['nom'];
                                                $tipus = $fila2['tipus'];
                                        ?>
                                                <div class="skills-imagen">
                                                    <img src="data:<?php echo $tipus_foto ?>;base64,<?php echo base64_encode($icona) ?>" alt="" title="<?php echo $nom_skill . ' [' . $tipus . ']' ?>">
                                                    <p style="color: black;"><?php echo $percentatge ?>%</p>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php
                                }

                                //Aqui muestras los alumnos relacionados al proyecto
                                if (isset($_POST['alumnesProjectes'])) {
                                    $id_projecte = $_POST['id_projecte'];
                                    $sql = "SELECT * FROM alumnes_projectes WHERE id_projecte = $id_projecte";
                                    $id_res = mysqli_query($conn, $sql);
                                ?>
                                    <div class="alumnes-container"> <!-- Agregado: Div general -->
                                        <button style="margin-top: -32px !important; margin-right: 0px !important;" onclick='cerrarInfoProjecteAlumnes()' class='cerrar-ventana'><i class='bx bx-x'></i></button>
                                        <?php
                                        while ($fila = mysqli_fetch_assoc($id_res)) {
                                            $id_alumne = $fila['id_alumne'];
                                            $sql_alumne = "SELECT * FROM alumnes WHERE id_alumne = $id_alumne";
                                            $id_res2 = mysqli_query($conn, $sql_alumne);
                                            while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                $nom_alumne = $fila2['nom'];
                                                $cognoms_alumne = $fila2['cognoms'];
                                                $foto_perfil = $fila2['foto_perfil'];
                                                $tipus_foto = $fila2['tipus_foto'];
                                        ?>
                                                <div class="alumnes">
                                                    <img src="data:<?php echo $tipus_foto ?>;base64,<?php echo base64_encode($foto_perfil) ?>" alt="">
                                                    <p><?php echo $nom_alumne . " " . $cognoms_alumne ?></p>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div> <!-- Agregado: Cierre del div general -->
                                    <?php
                                }
                                if (isset($_POST['modificarProjecte'])) {
                                    $id_projecte = $_POST['id_projecte'];
                                    $sql_projecte = "SELECT * FROM projectes WHERE id_projecte = $id_projecte";
                                    $id_res = mysqli_query($conn, $sql_projecte);
                                    echo "<div class='modificar-projecte'>";
                                    echo "<h3>MODIFICAR PROJECTE</h3>";
                                    echo "<button onclick='cerrarModificarProjectes()' style='margin-top: -70px !important; margin-right: -20px !important;' class='cerrar-ventana'><i class='bx bx-x'></i></button>";
                                    echo "<form method='post'>";
                                    while ($fila = mysqli_fetch_assoc($id_res)) {
                                        $nom = $fila['nom'];
                                        $modul = $fila['modul'];
                                    ?>
                                        <div class="nom">
                                            <label for="">Nom</label>
                                            <input type="text" name="nom" id="nom" value="<?php echo $nom ?>">
                                        </div>
                                        <div class="modul">
                                            <label for="">Modul</label>
                                            <input type="number" name="modul" id="modul" value="<?php echo $modul ?>">
                                        </div>
                                    <?php
                                        $sql_alumnes = "SELECT * FROM alumnes";
                                        $id_res2 = mysqli_query($conn, $sql_alumnes);
                                        echo "<div class='alumnes-modificar-projecte'>";
                                        echo "<label for=''>Alumnes:</label><br>";

                                        // Obtén la lista de alumnos asociados al proyecto actual
                                        $sql_alumnes_proyecto_actual = "SELECT id_alumne FROM alumnes_projectes WHERE id_projecte = $id_projecte";
                                        $alumnos_proyecto_actual = [];
                                        $id_res_alumnos_proyecto_actual = mysqli_query($conn, $sql_alumnes_proyecto_actual);
                                        while ($fila_alumnos_proyecto_actual = mysqli_fetch_assoc($id_res_alumnos_proyecto_actual)) {
                                            $alumnos_proyecto_actual[] = $fila_alumnos_proyecto_actual['id_alumne'];
                                        }
                                        while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                            echo "<div class='alumnes-modificar-individual'>";
                                            $id_alumne = $fila2['id_alumne'];
                                            $nom_alumne = $fila2['nom'];
                                            $cognoms_alumne = $fila2['cognoms'];
                                            $curs = $fila2['curs'];
                                            $infoAlumne = $nom_alumne . " " . $cognoms_alumne . " - " . $curs;
                                            // Verifica si el alumno está en la lista de alumnos asociados al proyecto
                                            if (in_array($id_alumne, $alumnos_proyecto_actual)) {
                                                echo "<input type='checkbox' name='alumnes[]' value='$id_alumne' checked>";
                                            } else {
                                                echo "<input type='checkbox' name='alumnes[]' value='$id_alumne'>";
                                            }
                                            echo "<label for=''>$infoAlumne</label>";
                                            echo "<br>";
                                            echo "</div>";
                                        }
                                        echo "</div>";
                                        $sql_skills_projectes = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                                        $id_res3 = mysqli_query($conn, $sql_skills_projectes);
                                        // Obtener todas las habilidades de la tabla skills
                                        $sql_all_skills = "SELECT * FROM skills";
                                        $id_res_all_skills = mysqli_query($conn, $sql_all_skills);
                                        $all_skills = array();
                                        while ($fila_all_skills = mysqli_fetch_assoc($id_res_all_skills)) {
                                            $all_skills[$fila_all_skills['id_skill']] = $fila_all_skills['nom'];
                                        }
                                        echo "<div class='skills-projecte-all'>";
                                        echo "<h1>Skills:</h1>";
                                        // Iterar sobre todas las habilidades disponibles
                                        foreach ($all_skills as $id_skill => $nom_skill) {
                                            echo "<div class='skills-projecte'>";
                                            // Verificar si la habilidad está en la tabla skills_projectes
                                            $sql_check_skill = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte AND id_skill = $id_skill";
                                            $id_res_check_skill = mysqli_query($conn, $sql_check_skill);
                                            if ($fila_check_skill = mysqli_fetch_assoc($id_res_check_skill)) {
                                                // La habilidad está en la tabla, mostrar sin checkbox
                                                $id_skill_projecte = $fila_check_skill['id_skill_projecte'];
                                                $percentatge = $fila_check_skill['percentatge'];
                                                echo "<label for=''>$nom_skill</label>";
                                                echo "<div class='skills-porcentaje'>";
                                                echo "<input type='number' name='percentatge[$nom_skill]' value='$percentatge'>";
                                                echo "<label for=''>%</label>";
                                                echo "</div>";
                                                echo "<input type='hidden' name='skills[]' value='$nom_skill'>";
                                                echo "<input type='hidden' name='id_skill[$nom_skill]' value='$id_skill'>";
                                            } else {
                                                // La habilidad no está en la tabla, mostrar con checkbox
                                                echo "<input type='checkbox' name='skills[]' value='$nom_skill'>";
                                                echo "<label for=''>$nom_skill</label>";
                                                echo "<div class='skills-porcentaje'>";
                                                echo "<input type='number' name='percentatge[$nom_skill]' value='0'>";
                                                echo "<label for=''>%</label>";
                                                echo "</div>";
                                                echo "<input type='hidden' name='id_skill[$nom_skill]' value='$id_skill'>";
                                            }
                                            echo "</div>";
                                        }
                                    }
                                    echo "<input type='hidden' name='id_projecte' value='$id_projecte'>";
                                    echo "</div>";
                                    echo "<button name='modificacioProjecte'>Modificar</button>";
                                    echo "</form>";
                                    echo "</div>";
                                }


                                if (isset($_POST['borrarProjecte'])) {
                                    $id_projecte = $_POST['id_projecte'];
                                    ?>
                                    <div class="borrar-skills">
                                        <div class="borrar-skills-top">
                                            <h3>Estas segur de borrar este proyecto?</h3>
                                        </div>
                                        <div class="borrar-skills-all">
                                            <form method="post">
                                                <button type="button" onclick="cancelarBorrarSkills()">cancel·lar</button>
                                                <button class="borrar" name="borrarDefinitiuProjecte">borrar</button>
                                                <input type="hidden" name="id_projecte" value="<?php echo $id_projecte ?>">
                                            </form>
                                        </div>
                                    </div>
                                <?php
                                }

                                //Esto es para cuando quieres borrar una actividad
                                if (isset($_POST['borrarActivitat'])) {
                                    $id_activitat = $_POST['id_activitat'];
                                ?>
                                    <div class="borrar-skills">
                                        <div class="borrar-skills-top">
                                            <h3>Estas segur de borrar esta activitat?</h3>
                                        </div>
                                        <div class="borrar-skills-all">
                                            <form method="post">
                                                <button type="button" onclick="cancelarBorrarSkills()">cancel·lar</button>
                                                <button class="borrar" name="borrarDefinitiuActivitiat">borrar</button>
                                                <input type="hidden" name="id_activitat" value="<?php echo $id_activitat ?>">
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }

                                if (isset($_POST['creacioActivitats'])) {
                                    $id_projecte = $_POST['id_projecte'];
                                    $contador = 0;
                                    // Contar la cantidad de skills del proyecto
                                    $sql_skills_projectes = "SELECT COUNT(id_skill_projecte) AS conta FROM skills_projectes WHERE id_projecte = $id_projecte";
                                    $id_res = mysqli_query($conn, $sql_skills_projectes);
                                    $fila = mysqli_fetch_assoc($id_res);
                                    $conta = $fila['conta'];
                                    // Contar la cantidad de skills asignadas a actividades
                                    $sql_skills_activitats = "SELECT COUNT(id_skill_activitat) AS conta2 FROM skills_activitats WHERE id_skill_projecte IN (SELECT id_skill_projecte FROM skills_projectes WHERE id_projecte = $id_projecte)";
                                    $id_res2 = mysqli_query($conn, $sql_skills_activitats);
                                    $fila2 = mysqli_fetch_assoc($id_res2);
                                    $conta2 = $fila2['conta2'];
                                    // Verificar si todas las skills del proyecto están asignadas a actividades
                                    if ($conta > 0 && $conta == $conta2) {
                                        $contador++;
                                    }
                                    //Si aun quedan skills para assignar
                                    if ($contador == 0) {
                                    ?>
                                        <!---- Esto es para cuando quieres crear una actividad ---->
                                        <div class="crearActivitats">
                                            <h3>CREAR ACTIVITATS</h3>
                                            <button onclick="cerrarCrearActivitats()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
                                            <div class="crear-activitats-all">
                                                <form method="post">
                                                    <div class="nom">
                                                        <label for="">Nom</label>
                                                        <input type="text" name="nom" id="nom" required>
                                                    </div>
                                                    <div class="dataentrega">
                                                        <label for="">Data Entrega</label>
                                                        <input type="date" name="dataentrega" id="dataentrega" required>
                                                    </div>
                                                    <div class="activitat-activa">
                                                        <label for="">Activitat Activa</label>
                                                        <select name="activa" id="activa">
                                                            <option value="T">Activa</option>
                                                            <option value="F">No Activa</option>
                                                        </select>
                                                    </div>
                                                    <div class="select-skills">
                                                        <label for="">Skill</label>
                                                        <div class="all-skills">
                                                            <?php
                                                            //Hay que ponerlo bonito
                                                            $sql = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                                                            $id_res = mysqli_query($conn, $sql);
                                                            $i = 0;
                                                            while ($fila = mysqli_fetch_assoc($id_res)) {
                                                                $id_skill_projecte = $fila['id_skill_projecte'];
                                                                $id_skill = $fila['id_skill'];
                                                                $percentatge = $fila['percentatge'];
                                                                // Verificar si el id_skill_projecte no está en skills_activitats
                                                                $sql_skill_activitat = "SELECT * FROM skills_activitats WHERE id_skill_projecte = $id_skill_projecte";
                                                                $id_res2 = mysqli_query($conn, $sql_skill_activitat);
                                                                if (mysqli_num_rows($id_res2) == 0) {
                                                                    $sql_skills = "SELECT * FROM skills WHERE id_skill = $id_skill";
                                                                    $id_res3 = mysqli_query($conn, $sql_skills);
                                                                    while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                                                                        $nom = $fila3['nom'];
                                                                        $nomPercentatge = $nom . " " . $percentatge . "%";
                                                                        echo "<div style='margin-bottom: 5px;' class='skill'>";
                                                                        echo "<input type='radio' name='skill' value='" . $nom . "'>";
                                                                        echo "<label for=''>$nomPercentatge</label>";
                                                                        echo "</div>";
                                                                        $i++;
                                                                    }
                                                                }
                                                            }
                                                            echo "<input type='hidden' name='llargada' value='$i'>";
                                                            echo "<input type='hidden' name='id_projecte' value='" . $id_projecte . "'>";
                                                            echo "<input type='hidden' name='mostrarActivitat' value='" . $mostrarActivitats . "'>";
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="crear-activitats-all-button">
                                                        <button name="crearActivitats">CREAR</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                        echo "<script>alert(`Totes les skills estan assignades a alguna activitat`)</script>";
                                    }
                                }

                                if (isset($_POST['modificarActivitat'])) {
                                    $id_activitat = $_POST['id_activitat'];
                                    $sql = "SELECT * FROM activitats WHERE id_activitat = $id_activitat";
                                    $id_res = mysqli_query($conn, $sql);
                                    while ($fila = mysqli_fetch_assoc($id_res)) {
                                        $nom = $fila['nom'];
                                        $data_entrega = $fila['data_entrega'];
                                        $id_projecte = $_POST['id_projecte'];
                                        $activa = $fila['activa'];
                                    }
                                    ?>
                                    <!---- Esto es para cuando quieres modificar cada actividad ---->
                                    <div class="crearActivitats">
                                        <h3>Modificar ACTIVITATS</h3>
                                        <button onclick="cerrarModificarActivitats()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
                                        <div class="crear-activitats-all">
                                            <form method="post">
                                                <div class="nom">
                                                    <label for="">Nom</label>
                                                    <input type="text" name="nom" id="nom" value="<?php echo $nom ?>">
                                                </div>
                                                <div class="dataentrega">
                                                    <label for="">Data Entrega</label>
                                                    <input type="date" name="dataentrega" id="dataentrega" value="<?php echo $data_entrega ?>">
                                                </div>
                                                <div class="activitat-activa">
                                                    <label for="">Activitat Activa</label>
                                                    <select name="activa" id="activa">
                                                        <?php
                                                        if ($activa == 'T') {
                                                            echo "<option value='T' selected>Activa</option>";
                                                            echo "<option value='F'>No Activa</option>";
                                                        } else {
                                                            echo "<option value='T'>Activa</option>";
                                                            echo "<option value='F' selected>No Activa</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="select-skills">
                                                    <label for="">Skills</label>
                                                    <div class="all-skills">
                                                        <?php
                                                        $sql = "SELECT * FROM skills_projectes WHERE id_projecte = $id_projecte";
                                                        $id_res = mysqli_query($conn, $sql);
                                                        while ($fila = mysqli_fetch_assoc($id_res)) {
                                                            $id_skill_projecte = $fila['id_skill_projecte'];
                                                            $id_skill = $fila['id_skill'];
                                                            $percentatge = $fila['percentatge'];
                                                            $sql_skill = "SELECT * FROM skills WHERE id_skill = $id_skill";
                                                            $id_res2 = mysqli_query($conn, $sql_skill);
                                                            $i = 0;
                                                            while ($fila2 = mysqli_fetch_assoc($id_res2)) {
                                                                $tipus = $fila2['tipus'];
                                                                $nom = $fila2['nom'];
                                                                $sql_skill_activitat = "SELECT * FROM skills_activitats WHERE id_activitat = $id_activitat";
                                                                $id_res3 = mysqli_query($conn, $sql_skill_activitat);
                                                                while ($fila3 = mysqli_fetch_assoc($id_res3)) {
                                                                    $id_skill_projecte_2 = $fila3['id_skill_projecte'];
                                                                    echo "<div class='skill'>";
                                                                    if ($id_skill_projecte == $id_skill_projecte_2) {
                                                                        echo "<input type='radio' name='skill" . $i . "' value='$nom' checked>";
                                                                    } else {
                                                                        echo "<input type='radio' name='skill" . $i . "' value='$nom'>";
                                                                    }
                                                                    echo "<label for=''>$nom</label>";
                                                                    echo "</div>";
                                                                    $i++;
                                                                }
                                                            }
                                                            echo "<input type='hidden' name='llargada' value='$i'>";
                                                        }
                                                        echo "<input type='hidden' name='id_projecte' value='" . $id_projecte . "'>";
                                                        echo "<input type='hidden' name='id_activitat' value='" . $id_activitat . "'>";
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="crear-activitats-all-button">
                                                    <button name="modificacioActivitats">MODIFICAR</button>
                                                    <input type="hidden" name="mostrarActivitat" value="<?php echo $mostrarActivitats ?>">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <!---- Este div se muestra cuando quieres elegir las ls para cada proyecto ---->
                                <div id="escollirSkills">
                                    <h3>ESCOLLIR SKILLS</h3>
                                    <button onclick="cerrarEscollirSkills()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
                                    <form style="display: block; height: auto; margin: 0px" method="post">
                                        <button class="crear-escollir-skills" name="crearSkills">+</button>
                                    </form>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="pre-creacion">
                                            <div class="creacion">
                                                <?php
                                                //Hay que ponerlo bonito
                                                $sql = "SELECT nom FROM skills";
                                                $id_res = mysqli_query($conn, $sql);
                                                while ($fila = mysqli_fetch_assoc($id_res)) {
                                                    echo "<div class='skill'>";
                                                    echo "<input type='checkbox' name='skills[]' value='" . $fila['nom'] . "'>";
                                                    echo "<label for=''>" . $fila['nom'] . "</label>";
                                                    echo "<input type='number' name='percentatge[" . $fila['nom'] . "]' min='0' max='100' value='0'>";
                                                    echo "<label for=''>%</label>";
                                                    echo "</div>";
                                                }
                                                if (!empty($id_alumnes)) {
                                                    echo "<input type='hidden' name='alumnes' value='" . htmlspecialchars(serialize($id_alumnes)) . "'>";
                                                }
                                                ?>
                                            </div>
                                            <div>
                                                <button name="escollir">ESCOLLIR</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php

                                if (isset($_POST['crearSkills'])) {
                                ?>
                                    <!---- Este div se muestra cuando quieres crear una skill ---->
                                    <div id="crearSkills">
                                        <h3>CREAR SKILLS</h3>
                                        <button onclick="cerrarCrearSkills()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="creando">
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
                                                <div class="icona">
                                                    <label for="foto">Icona</label>
                                                    <input type="file" name="foto" accept="image/*" required>
                                                </div>
                                                <div class="creando-button">
                                                    <button name="creacio">CREAR</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php
                                }
                                ?>

                                <!---- Este div es para mostrar todas las skill creadas ---->
                                <div class="skillsCreadas">
                                    <h2>SKILLS</h2>
                                    <div class="skill-general">
                                        <?php
                                        $sql = "SELECT id_skill, nom, icona, tipus_foto, tipus FROM skills";
                                        $id_res = mysqli_query($conn, $sql);
                                        while ($fila = mysqli_fetch_assoc($id_res)) {
                                            echo "<div class='skills'>";
                                            echo "<img src='data:" . $fila['tipus_foto'] . ";base64," . base64_encode($fila['icona']) . "' alt=''>";
                                            echo "<br>";
                                            echo "<br>";
                                            echo "<label for=''>" . $fila['nom'] . "</label>";
                                            echo "<br>";
                                            echo "<br>";
                                            echo "<label for=''>" . $fila['tipus'] . "</label>";
                                            echo "<br>";
                                            echo "<br>";
                                            echo "<div class='skill-icons'>";
                                            echo "<form method='post'>";
                                            echo "<button name='modificar'><i class='bx bx-edit-alt'></i></button>";
                                            echo "<button name='borrar'><i class='bx bx-trash'></i></button>";
                                            echo "<input type='hidden' name='id_skill' value='" . $fila['id_skill'] . "'>";
                                            echo "</form>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                if (isset($_POST['borrar'])) {
                                    $id_skill = $_POST['id_skill'];
                                ?>
                                    <!---- Este div se muestra cuando quieres borrar una skill ---->
                                    <div class="borrar-skills">
                                        <div class="borrar-skills-top">
                                            <h3>Estas segur de borrar esta skill?</h3>
                                        </div>
                                        <div class="borrar-skills-all">
                                            <form method="post">
                                                <button type="button" onclick="cancelarBorrarSkills()">cancel·lar</button>
                                                <button class="borrar" name="borrarSkill">borrar</button>
                                                <input type="hidden" name="id_skill" value="<?php echo $id_skill ?>">
                                            </form>
                                        </div>
                                    </div>

                                <?php
                                }

                                if (isset($_POST['modificar'])) {
                                    $id_skill = $_POST['id_skill'];
                                    $sql = "SELECT * FROM skills WHERE id_skill = $id_skill";
                                    $id_res = mysqli_query($conn, $sql);
                                    while ($fila = mysqli_fetch_assoc($id_res)) {
                                        $nom = $fila['nom'];
                                        $tipus = $fila['tipus'];
                                        $id_skill = $fila['id_skill'];
                                    }
                                ?>
                                    <!---- Este div se muestra al quere modificar una skill ---->
                                    <div class="modificar-skills">
                                        <h3>MODIFICAR SKILLS</h3>
                                        <button onclick="cerrarModificarSkills()" class="cerrar-ventana"><i class='bx bx-x'></i></button>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="creando">
                                                <div class="nom">
                                                    <label for="">Nom</label>
                                                    <input type="text" name="nom" id="nom" value="<?php echo $nom ?>">
                                                </div>
                                                <div class="tipus">
                                                    <label for="">Tipus</label>
                                                    <select name="tipus" id="tipus">
                                                        <?php
                                                        if ($tipus == "Hard") {
                                                            echo "<option value='Hard' selected>Hard</option>";
                                                            echo "<option value='Soft'>Soft</option>";
                                                        } else {
                                                            echo "<option value='Hard'>Hard</option>";
                                                            echo "<option value='Soft' selected>Soft</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="icona">
                                                    <label for="foto">Icona</label>
                                                    <input type="file" name="foto" accept="image/*">
                                                </div>
                                                <div class="creando-button">
                                                    <button name="modificarSkill">MODIFICAR</button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="id_skill" value="<?php echo $id_skill ?>">
                                        </form>
                                    </div>

                                <?php
                                }
                                ?>
                                <!---- Div en el cual se muestran los alumnos para escgerlos para los proyetos ---->
                                <div id="escollir-alumnes">
                                    <h3>ESCOLLIR ESTUDIANTS</h3>
                                    <button onclick='cerrarEstudiants()' class='cerrar-ventana'><i class='bx bx-x'></i></button>";
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="escollir-alumnes-seleccio">
                                            <?php
                                            $sql = "SELECT id_alumne, nom, cognoms, curs, foto_perfil, tipus_foto FROM alumnes";
                                            $id_res = mysqli_query($conn, $sql);
                                            while ($fila = mysqli_fetch_assoc($id_res)) {
                                                $nomComplert = $fila['nom'] . " " . $fila['cognoms'];
                                                echo "<div class='seleccio-alumnat'>";
                                                echo "<input type='checkbox' name='alumnes[]' value='" . $fila['id_alumne'] . "'>";
                                                echo "<img src='data:" . $fila['tipus_foto'] . ";base64," . base64_encode($fila['foto_perfil']) . "' alt=''>";
                                                echo "<label for=''>$nomComplert</label>";
                                                echo "<label for=''>" . $fila['curs'] . "</label>";
                                                echo "</div>";
                                            }
                                            if (!empty($skills) && !empty($percentatgeSkills)) {
                                                echo "<input type='hidden' name='skills' value='" . htmlspecialchars(serialize($skills)) . "'>";
                                                echo "<input type='hidden' name='percentatge' value='" . htmlspecialchars(serialize($percentatgeSkills)) . "'>";
                                            }
                                            ?>
                                        </div>
                                        <br><br>
                                        <div class="boton">
                                            <button id="crear" name="escollirAlumnes">ESCOLLIR</button>
                                        </div>
                                    </form>
                                </div>
                                <footer>
                                    <p>Derechos de imagen @Chamous</p>
                                </footer>
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
                                <script src="js/professores.js"></script>
</body>

</html>