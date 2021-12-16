window.addEventListener("load",function(){
    var fichero = document.getElementById("subirCsv");
    var area = document.getElementById("area");
    var boton = document.getElementById("boton");

    fichero.addEventListener("change",function(){
        readFile(this, area);
    })

    boton.addEventListener("click",function(e){
        e.preventDefault();
        preguntas = [];
        dato = area.value.split("\n");
        for(w=0;w<dato.length;w++)
        {
            vectorR = [];
            preguntaSola = dato[w].split(",");
            for(j=0;j<7;j++)
            {
                preguntaSola[j] = preguntaSola[j].replaceAll(" ","");
            }
            for(j=3;j<7;j++)
            {
                vectorR[j] = preguntaSola[j];
            }
            vectorR = vectorR.filter(function (el) {
                return el != null;
              });
            preg = new pregunta(null,preguntaSola[0], preguntaSola[1], null, preguntaSola[2], vectorR);
            preguntas[w] = preg;
        }
        dato = preguntas;

        dato = JSON.stringify(dato);
        const formdata = new FormData();
        formdata.append("preguntas",dato);

        fetch("../../php/ajax/ajaxInsertaMasiva", { method: 'POST', body: formdata })
        .then(response => response.json())
        .then(data => {
            if(data==null)
            {
                alert("EL ALTA SE REALIZÓ CON ÉXITO");
            }
            if(data==1062)//error de clave duplicada en mysql
            {
                alert("ERROR, DATOS YA EXISTENTES");
            }
        })
        
        
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