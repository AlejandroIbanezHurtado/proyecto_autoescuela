window.addEventListener("load",function(){
    var nav = document.getElementsByTagName("nav");
    fetch("../../php/ajax/ajaxSesion.php")
    .then(response => response.json())
    .then(data => {
        cargaPagina(data);
    });

    function cargaPagina(data)
    {
        switch(data)
        {
            case "alumno":
                nav[0].classList.add("ocultar");
                console.log("cargar alumno");
                break;
            case "administrador":
                nav[1].classList.add("ocultar");
                // MOSTRAR TABLA DE HISTORICO DE EXAMENES DE USUARIOS
                // listado(1,5,"../../php/ajax/ajaxExamenesPag.php",["descripcion","duracion","num_preguntas"],"examen");
                break;
            case "nada":
                window.location.href = "../../php/paginas/login.php";
                break;
        }
    }
})