let prueba = document.getElementById("prueba");
let modificaralumnes = document.getElementById("modificar");
let escollirestudiants = document.getElementById("escollir-alumnes");
let all = document.getElementsByClassName("Professors_Estudiants");
let escollirSkills = document.getElementById("escollirSkills");
let crearSkills = document.getElementById("crearSkills");
let planaactivitats = document.querySelector(".planaactivitats");
let modificaractivitats = document.querySelector(".crearActivitats");
let borrarskills = document.querySelector(".borrar-skills");
let modificarskills = document.querySelector(".modificar-skills");
let crearactivitats = document.querySelector(".crearActivitats");
let borrarprojectes = document.querySelector(".borrar-projectes");
let borraractivitats = document.querySelector(".borrar-activitats");
let infoprojecte = document.querySelector(".info-projecte");
let infoprojectealumnes = document.querySelector(".alumnes-container");
let infoprojecteskills = document.querySelector(".skills-container");
let modificarprojectes = document.querySelector(".modificar-projecte");

function cerrarModificarProjectes() {
    modificarprojectes.style.display = "none";
}

function mostrarCrear() {
    prueba.style.display = "block";
}

function cerrarCrearAlumnes(){
    prueba.style.display = "none";
}

function cerrarModificarAlumnes(){
    modificaralumnes.style.display = "none";
}

function mostrarSkills() {
    escollirSkills.style.display = "block";
    escollirestudiants.style.display = "none";
    crearSkills.style.display = "none";
}

function mostrarEstudiants() {
    escollirestudiants.style.display = "block";
    escollirSkills.style.display = "none";
    crearSkills.style.display = "none";
}

function cerrarEstudiants(){
    escollirestudiants.style.display = "none";
}

function cancelarBorrarSkills(){
    borrarskills.style.display = "none";
}

function cerrarEscollirSkills(){
    escollirSkills.style.display = "none";
}

function cerrarEscollirSkills2() {
    let escollirSkills2 = document.getElementById("escollirSkills2");
    escollirSkills2.style.display = "none";
}

function cerrarCrearSkills(){
    crearSkills.style.display = "none";
}

function cerrarCrearActivitats(){
    crearactivitats.style.display = "none";
}

function cerrarModificarActivitats(){
    modificaractivitats.style.display = "none";
}

function cerrarModificarSkills(){
    modificarskills.style.display = "none";
}

function cerrarInfoProjecteAlumnes(){
    infoprojectealumnes.style.display = "none";
}

function cerrarInfoProjecteSkills(){
    infoprojecteskills.style.display = "none";
}