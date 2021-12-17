window.addEventListener("load",function(){
    fetch("../../php/ajax/ajaxSesion.php")
    .then(response => response.json())
    .then(data => {
        cargaPagina(data);
    });

    fetch("../../php/ajax/ajaxSesionEditar.php")
    .then(response => res = response);
    function cargaPagina(data)
    {
        if(window.location.href=="http://localhost/autoescuela/js/paginas/listado_examenes.html" || window.location.href=="http://www.autoescuela.com/js/paginas/listado_examenes.html")
        {
            switch(data)
            {
                case "alumno":
                    listado(1,5,"../../php/ajax/ajaxExamenesPagA.php",["descripcion","duracion","num_preguntas","activo"],"examen", "alumno");
                    break;
                case "administrador":
                    listado(1,5,"../../php/ajax/ajaxExamenesPag.php",["descripcion","duracion","num_preguntas","activo"],"examen");
                    break;
                case "nada":
                    window.location.href = "../../php/paginas/login.php";
                    break;
            }
        }
        else{

            if(window.location.href=="http://localhost/autoescuela/js/paginas/historico.html" || window.location.href=="http://www.autoescuela.com/js/paginas/historico.html")
            {
                switch(data)
                {
                    case "alumno":
                        fetch("../../php/ajax/ajaxSaberCorreoUsuario.php")
                        .then(response => response.json())
                        .then(data => {
                            listado(1,5,"../../php/ajax/ajaxExamenesUsuariosPag.php?alumno="+data+"&",["id_examen","fecha","calificacion"],"examen_usuario", "alumno");
                        });
                        break;
                    case "administrador":
                        listado(1,5,"../../php/ajax/ajaxExamenesUsuariosPag.php",["id_examen","fecha","id_usuario","calificacion"],"examen_usuario");
                        break;
                    case "nada":
                        window.location.href = "../../php/paginas/login.php";
                        break;
                }
            }
            else{
                switch(data)
                {
                    case "alumno":
                        window.location.href = "../../php/paginas/login.php";
                        break;
                    case "administrador":
                        console.log("cargar administrador");
                        break;
                    case "nada":
                        window.location.href = "../../php/paginas/login.php";
                        break;
                }
            }
        }
        
    }
})