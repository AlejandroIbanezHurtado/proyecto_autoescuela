window.addEventListener("load",function(){
    var fichero = document.getElementById("subirCsv");
    var area = document.getElementById("area");
    var boton = document.getElementById("boton");

    fichero.addEventListener("change",function(){
        readFile(this, area);
    })

    boton.addEventListener("click",function(e){
        e.preventDefault();
        valido = true;
        dato = area.value.replaceAll("\n","").split(",");
        for(i=0;i<dato.length;i++)
        {
            dato[i] = dato[i].replaceAll(" ","");
            if(!(/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/.test(dato[i])))
            {
                valido = false;
                break;
            }
        }
        if(!valido)
        {
            alert("ERROR, revise el archivo CSV");
        }
        else{
            dato = JSON.stringify(dato);
            const formdata = new FormData();
            formdata.append("usuarios",dato);
    
            fetch("../../php/ajax/ajaxInsertaMasiva", { method: 'POST', body: formdata })
            .then(response => response.json())
            .then(data => {
                if(data==null)
                {
                    alert("EL ALTA SE REALIZÓN CON ÉXITO");
                }
                else{
                    if(data==1062)
                    {
                        alert("ERROR, HAY USUARIOS CON ESE CORREO");
                    }
                    else{
                        alert("ERROR, NO SE HA PODIDO REALIZAR CON ÉXITO");
                    }
                }
                
            })
        }
        
    })
})
function readFile(input, area) {
    let file = input.files[0];
    let reader = new FileReader();
    reader.readAsText(file);
    
    reader.onload = function() {
        area.value = reader.result;
    };
    
    reader.onerror = function() {
        console.log(reader.error);
    };
  
}