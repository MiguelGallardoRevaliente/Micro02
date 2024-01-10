let prueba = document.getElementById("prueba");
let escollirestudiants = document.getElementById("escollir-alumnes");
let all = document.getElementsByClassName("Professors_Estudiants");
let escollirSkills = document.getElementById("escollirSkills");
let crearSkills = document.getElementById("crearSkills");
let planaactivitats = document.getElementsByClassName("plana-activitats");
let body = document.body;
function mostrarCrear() {
    prueba.style.display = "block";
}

function mostrarSkills() {
    escollirSkills.style.display = "block";
}

function creacioSkills() {
    escollirSkills.style.display = "none";
    crearSkills.style.display = "block";
}

function skillCreada() {
    crearSkills.style.display = "none";
    escollirSkills.style.display = "block";
}

function mostrarActivitats (){
    planaactivitats.style.display = "block";

}

function mostrarEstudiants() {
    escollirestudiants.style.display = "block";
}