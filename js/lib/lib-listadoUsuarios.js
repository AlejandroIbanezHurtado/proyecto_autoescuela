window.addEventListener("load",function(){
    var tabla = document.getElementById("tabla");
    var tbody = tabla.children[1];
    var pagina = 1;
    var filas = 3;
    fetch("../../php/ajax/ajaxUsuariosPag.php?pagina="+pagina+"&filas="+filas)
    .then(response => response.json())
    .then(data => {
        cargaTabla(data);
    });
    function cargaTabla(data)
    {
        for(i=0;i<data.length;i++)
        {
            fila = document.createElement("tr");
            columnas = ["correo","nombre","apellidos","fecha_nac","rol"];
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
})