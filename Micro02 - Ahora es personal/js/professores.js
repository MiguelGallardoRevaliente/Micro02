let prueba = document.getElementById("prueba");
let modificar = document.getElementById("modificar");
let all = document.getElementsByClassName("Professors_Estudiants");
function mostrarCrear() {
    prueba.style.display = "block";
    modificar.style.display = "none";
}

function mostrarmodificar(){
    modificar.style.display = "block";
    prueba.style.display = "none";
}
