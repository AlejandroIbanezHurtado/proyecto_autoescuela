window.addEventListener("load",function(){
    var caja = document.getElementById("cajaUser");
    var foto = document.getElementsByClassName("fotoUsuario")[0];
    var cierra = document.getElementById("cierraSesion");
    var editar = document.getElementById("editar");
    //vemos si el usuario que ha iniciado sesion tiene foto
    fetch("../../php/ajax/ajaxMiraImagenUsuario.php")
    .then(response => response.json())
    .then(data => {
        if(data!=null && data!="")
        {
            src = "http://localhost/autoescuela"+data.substr(5,200);
            console.log(src);
            foto.src = src;
            foto.width=50;
        }
    });
    
    foto.addEventListener("click",function(){
        caja.classList.toggle("ocultar");
    })
    editar.addEventListener("click",function(){
        fetch("../../php/ajax/ajaxEditarUsuario.php?");
        window.location.href = "../../php/paginas/alta_usuario.php";
    })
    cierra.addEventListener("click",function(){
        fetch("../../php/ajax/ajaxCierraSesion.php")
        .then(response => response.json())
        .then(data => {
            console.log("Se ha cerrado sesion");
        });
        window.location.href = "../../php/paginas/login.php";
    })
})