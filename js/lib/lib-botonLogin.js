window.addEventListener("load",function(){
    var caja = document.getElementById("cajaUser");
    var foto = document.getElementsByClassName("fotoUsuario")[0];
    var cierra = document.getElementById("cierraSesion");
    var editar = document.getElementById("editar");
    var foto1 = document.getElementsByClassName("fotoAutoescuela")[0];
    var alta_usuario = document.body.querySelector("a[href='../../php/paginas/alta_usuario.php']");
    var alta_tematica = document.body.querySelector("a[href='../../php/paginas/alta_tematica.php']");
    var alta_pregunta = document.body.querySelector("a[href='../../php/paginas/alta_pregunta.php']");
    var alta_examen = document.body.querySelector("a[href='../../js/paginas/alta_examen.php']");
    var footer = document.createElement("footer");

    try{
        alta_usuario.addEventListener("click",function(){
            fetch("../../php/ajax/ajaxCierraSesionEditar.php?tabla=Usuario");
            window.location.href = "../../php/paginas/alta_usuario.php";
        })
    }catch(error){}
    
    try{
        alta_pregunta.addEventListener("click",function(){
            fetch("../../php/ajax/ajaxCierraSesionEditar.php?tabla=Pregunta");
            window.location.href = "../../php/paginas/alta_pregunta.php";
        })
    }catch(error){}
    

    foto1.addEventListener("click",function(){
        window.location.href = "../../js/paginas/historico.html";
    })
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

    mapa = document.createElement("article");
    a = document.createElement("a");
    a.innerText = "Mapa de navegaci??n";
    a.href = "../../Mapa_navegacion.pdf";
    mapa.appendChild(a);
    guia = document.createElement("article");
    a = document.createElement("a");
    a.innerText = "Gu??a de estilos";
    a.href = "../../guiaEstilos.pdf";
    guia.appendChild(a);
    dgt = document.createElement("article");
    a = document.createElement("a");
    a.innerText = "DGT";
    a.href = "https://www.dgt.es/inicio/";
    dgt.appendChild(a);
    footer.appendChild(mapa);
    footer.appendChild(guia);
    footer.appendChild(dgt);
    document.getElementsByTagName("body")[0].appendChild(footer);
})