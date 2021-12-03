window.addEventListener("load",function(){
    var tabla = document.getElementById("tabla");
    var tbody = tabla.children[1];
    fetch("../../php/ajax/ajaxUsuariosPag.php")
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
            a.innerText = "Eliminar";
            celda.appendChild(a);
            fila.appendChild(celda);
            tbody.appendChild(fila);
        }
    }
})