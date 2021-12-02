window.addEventListener("load",function(){
    var caja = document.getElementById("cajaUser");
    var foto = document.getElementsByClassName("fotoUsuario")[0];
    var cierra = document.getElementById("cierraSesion");
    foto.addEventListener("click",function(){
        caja.classList.toggle("ocultar");
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