function listado(pagina, filas, ruta, columnas, nombreTabla, rol="administrador"){
    var tabla = document.getElementById("tabla");
    var tabla2 = document.getElementById("tabla2");
    var lista = document.getElementById("listaTabla");
    var tbody = tabla.children[1];
    if(rol=="alumno")
    {
        tabla2.classList.remove("ocultar");
        tbody = tabla2.children[1];
    }
    else{
        tabla.classList.remove("ocultar");
        tbody = tabla.children[1];
    }
    fetch("../../php/ajax/ajaxCuentaRegistros.php?tabla="+nombreTabla)
    .then(response => response.json())
    .then(data => {
        nPag = data/filas;
        console.log(data);
        var atras = document.createElement("li");
        atras.innerText = "<";
        atras.addEventListener("click",function(){
            if(pagina!=1)
            {
                vaciarTabla();
                pagina=pagina-1;
                fetch(ruta+"?pagina="+pagina+"&filas="+filas)
                .then(response => response.json())
                .then(data => {
                    cargaTabla(data, pagina);
                });
            }
        })
        lista.appendChild(atras);
        
        if(nPag<=5)
        {
            for(i=0;i<nPag;i++)
            {
                p = document.createElement("li");
                p.innerText = i+1;
                p.setAttribute("id",i+1);
                p.classList.add("num");
                p.addEventListener("click",function(){
                    vaciarTabla();
                    pagina = this.innerText;
                    fetch(ruta+"?pagina="+pagina+"&filas="+filas)
                    .then(response => response.json())
                    .then(data => {
                        cargaTabla(data, pagina);
                    });
                })
                lista.appendChild(p);
            }
        }
        else{
            for(i=0;i<5;i++)
            {
                p = document.createElement("li");
                p.innerText = i+1;
                p.setAttribute("id",i+1);
                p.classList.add("num");
                p.addEventListener("click",function(){
                    vaciarTabla();
                    pagina = this.innerText;
                    fetch(ruta+"?pagina="+pagina+"&filas="+filas)
                    .then(response => response.json())
                    .then(data => {
                        cargaTabla(data, pagina);
                    });
                })
                lista.appendChild(p);
            }
        }

        var delante = document.createElement("li");
        delante.innerText = ">";
        delante.addEventListener("click",function(){
            pagina = parseInt(pagina);
            if(pagina<nPag)
            {
                vaciarTabla();
                pagina=pagina+1;
                fetch(ruta+"?pagina="+pagina+"&filas="+filas)
                .then(response => response.json())
                .then(data => {
                    cargaTabla(data, pagina);
                });
            }
        })
        lista.appendChild(delante);
    });
    let ruta2 = null;
    if(ruta.substr(-3)=="php")
    {
        ruta2 = ruta+"?pagina="+pagina+"&filas="+filas;
    }
    else{
        ruta2 = ruta+"pagina="+pagina+"&filas="+filas;
    }
    fetch(ruta2)
    .then(response => response.json())
    .then(data => {
        cargaTabla(data, pagina);
    });
    function cargaTabla(data, pagina)
    {
        p = document.getElementsByClassName("num");
        for(i=0;i<p.length;i++) p[i].style.textDecoration="none";
        if(pagina<=p.length)
        {
            p = document.getElementById(pagina);
            p.style.textDecoration="underline";
        }
        
        for(i=0;i<data.length;i++)
        {
            fila = document.createElement("tr");
            valor="";
            for(j=0;j<columnas.length;j++)
            {
                celda = document.createElement("td");
                celda.innerText = data[i][columnas[j]];
                fila.appendChild(celda);
            }
            if(rol!="alumno")
            {
                valor = data[i].id;
                celda = document.createElement("td");
                a = document.createElement("a");
                a.setAttribute("href","#");
                a.setAttribute("valor",valor);
                a.addEventListener("click",function(){
                    editar(nombreTabla, this.getAttribute("valor"));
                })
                a2 = document.createElement("a");
                a2.setAttribute("valor",valor);
                a2.addEventListener("click",function(){
                    eliminar(nombreTabla, this.getAttribute("valor"));
                })
                a2.setAttribute("href","#");
                celda.appendChild(a); //editar
                celda.appendChild(a2); //eliminar
                if(nombreTabla=="examen")
                {
                    a3 = document.createElement("a");
                    a3.setAttribute("valor",valor);
                    a3.addEventListener("click",function(){
                        desactivar(this.getAttribute("valor"), this.parentElement.parentElement.children[3].getAttribute("activo"));
                    })
                    celda.appendChild(a3);
                    celda.style.width="110px";
                }
                else{
                    celda.style.width="70px";
                }
                fila.appendChild(celda);
            }
            else{
                valor = data[i].id;
                celda = document.createElement("td");
                a = document.createElement("a");
                a.setAttribute("href","#");
                a.setAttribute("valor",valor);
                a.style.backgroundImage="none";
                if(ruta!="../../php/ajax/ajaxExamenesPag.php")
                {
                    a.innerText = "Revisar";
                    a.addEventListener("click",function(){
                        revisarExamen(this.getAttribute("valor"));
                    })
                }
                else{
                    a.innerText = "Realizar";
                    a.addEventListener("click",function(){
                        realizarExamen(this.getAttribute("valor"));
                    })
                }
                
                celda.appendChild(a); //realizar examen
                fila.appendChild(celda);
            }
            tbody.appendChild(fila);
            if(nombreTabla=="examen"){
                activo = tbody.children[i].children[3].innerText;
                if(activo=="SI")
                {
                    tbody.children[i].children[3].setAttribute("activo",0);
                }else{
                    tbody.children[i].children[3].setAttribute("activo",1);
                }
            }
        }
    }
    function vaciarTabla()
    {
        long = tbody.children.length;
        for(i=0;i<long;i++)
        {
            tbody.removeChild(tbody.children[0]);
        }
    }
    function editar(tabla, valor)
    {
        switch(tabla)
        {
            case "usuarios":
                fetch("../../php/ajax/ajaxEditarAlta.php?tabla=Usuario&valor="+valor);
                window.location.href = "../../php/paginas/alta_usuario.php";
                break;
            case "preguntas":
                fetch("../../php/ajax/ajaxEditarAlta.php?tabla=Pregunta&valor="+valor);
                window.location.href = "../../php/paginas/alta_pregunta.php";
                break;
            case "tematica":
                window.location.href = "../../php/paginas/alta_tematica.php";
                break;
            case "examen":
                window.location.href = "../../js/paginas/alta_examen.html";
                break;
        }
    }
    function eliminar(tabla, valor)
    {
        if (confirm("Al eliminar, este registro ya no pertenecerá a"+tabla))
        {
            fetch("../../php/ajax/ajaxBorrarId.php?tabla="+tabla+"&valor="+valor);
        }
        window.location.reload();
    }

    function desactivar(valor, activo)
    {
        fetch("../../php/ajax/ajaxDesactivarExamen.php?valor="+valor+"&activo="+activo);
        window.location.reload();
    }

    function realizarExamen(valor)
    {
        fetch("../../php/ajax/ajaxRealizarExamen.php?valor="+valor);
        window.location.href="../../js/paginas/realizaExamen.html";
    }

    function revisarExamen(valor)
    {
        fetch("../../php/ajax/ajaxRealizarExamen.php?valor="+valor+"&revisar=1");
        window.location.href="../../js/paginas/realizaExamen.html";
    }
}