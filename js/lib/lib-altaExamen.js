window.addEventListener("load",function(){
    const cajaDisponibles = document.getElementById("preguntasDisponibles");
    const cajaSeleccionadas = this.document.getElementById("preguntasSeleccionadas");

    fetch("../../php/ajax/ajaxPreguntas.php")
    .then(response => response.json())
    .then(data => {
        rellenaPreguntasDisponibles(data)
    });

    function rellenaPreguntasDisponibles(data){
        console.log(data);
        debugger;
        cajaDisponibles.innerText=data;
    }
    
})