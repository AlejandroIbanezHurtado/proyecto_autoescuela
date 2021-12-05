window.addEventListener("load",function(){
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
})