function listado(pagina, filas, ruta, columnas, nombreTabla){
    var tabla = document.getElementById("tabla");
    var lista = document.getElementById("listaTabla");
    var tbody = tabla.children[1];
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
                    cargaTabla(data);
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
                p.addEventListener("click",function(){
                    vaciarTabla();
                    pagina = this.innerText;
                    fetch(ruta+"?pagina="+pagina+"&filas="+filas)
                    .then(response => response.json())
                    .then(data => {
                        cargaTabla(data);
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
                p.addEventListener("click",function(){
                    vaciarTabla();
                    pagina = this.innerText;
                    fetch(ruta+"?pagina="+pagina+"&filas="+filas)
                    .then(response => response.json())
                    .then(data => {
                        cargaTabla(data);
                    });
                })
                lista.appendChild(p);
            }
        }

        var delante = document.createElement("li");
        delante.innerText = ">";
        delante.addEventListener("click",function(){
            if(pagina<nPag)
            {
                vaciarTabla();
                pagina=pagina+1;
                fetch(ruta+"?pagina="+pagina+"&filas="+filas)
                .then(response => response.json())
                .then(data => {
                    cargaTabla(data);
                });
            }
        })
        lista.appendChild(delante);
    });
    fetch(ruta+"?pagina="+pagina+"&filas="+filas)
    .then(response => response.json())
    .then(data => {
        cargaTabla(data);
    });
    function cargaTabla(data)
    {
        for(i=0;i<data.length;i++)
        {
            fila = document.createElement("tr");
            for(j=0;j<columnas.length;j++)
            {
                celda = document.createElement("td");
                celda.innerText = data[i][columnas[j]];
                fila.appendChild(celda);
            }
            celda = document.createElement("td");
            a = document.createElement("a");
            a.setAttribute("href","#");
            a.innerText = "Editar";
            a2 = document.createElement("a");
            a2.setAttribute("href","#");
            a2.innerText = "Eliminar";
            celda.appendChild(a);
            celda.appendChild(a2);
            fila.appendChild(celda);
            tbody.appendChild(fila);
        }
    }
    function vaciarTabla()
    {
        for(i=0;i<tbody.children.length+1;i++)
        {
            tbody.removeChild(tbody.children[0]);
        }
    }
}