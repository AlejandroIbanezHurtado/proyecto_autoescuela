window.addEventListener("load",function(){
    var body = document.getElementsByTagName("body")[0];
    fetch("../../php/ajax/ajaxSaberExamen")
        .then(response => response.json())
        .then(data => {
            examen = data[0];
        });
    fetch("../../php/ajax/ajaxDameExamen")
    .then(response => response.json())
    .then(data => {
        numPreg=0;
        for(var i in data)
        {
            numPreg++;
        }
        e = data;
        cont = 0;
        for(var i in data)
        {
            cont ++;
            //CAJA PRINCIPAL
            sectionPrin = document.createElement("section");
            sectionPrin.setAttribute("num",cont);
            sectionPrin.classList.add("ocultar");
            sectionPrin.classList.add("preguntaPrincipal");
            // sectionPrin.style.backgroundColor = "red";//para ver donde esta section

            //ENUNCIADO
            enunciado = document.createElement("p");
            enunciado.innerText = cont+" - "+data[i].enunciado;
            sectionPrin.appendChild(enunciado);

            //IMAGEN
            imagen = document.createElement("img");
            if(data[i].recurso!=null && data[i].recurso!="")
            {
                imagen.src=data[i].recurso;
            }
            else{
                imagen.src="../../archivos/imagenesWeb/imagen.png";
            }
            sectionPrin.appendChild(imagen);

            //CONTENEDOR RESPUESTAS
            contRes = document.createElement("section");
            contRes.setAttribute("num",cont);
            contRes.setAttribute("id_preg",data[i].id);
            //RESPUESTAS
            letras = ["a)","b)","c)","d)"];
            for(j=0;j<data[i].vectorRespuestas.length;j++)
            {
                enunRes = document.createElement("span");
                enunRes.innerText=letras[j]+" "+data[i].vectorRespuestas[j].enunciado;
                radio = document.createElement("input");
                radio.type="radio";
                radio.name="res"+cont;
                radio.setAttribute("id_res",data[i].vectorRespuestas[j].id);
                contRes.appendChild(enunRes);
                contRes.appendChild(radio);
                br = document.createElement("br");
                br2 = document.createElement("br");
                contRes.appendChild(br);
                contRes.appendChild(br2);
            }
            sectionPrin.appendChild(contRes);

            //TABLA NAV
            tabla = document.createElement("table");
            tbody = document.createElement("tbody");
            nfilas = Math.ceil(numPreg/10);
            for(w=0;w<nfilas;w++)
            {
                fila = document.createElement("tr");
                if(w==nfilas-1)
                {
                    if(numPreg<10)
                    {
                        for(j=0;j<numPreg;j++)
                        {
                            creaCelda(j);
                        }
                    }
                    else{
                        n = numPreg.toString().substr(1);
                        for(j=0;j<n;j++)
                        {
                            creaCelda(j);
                        }
                    }
                    
                }
                else{
                    for(j=0;j<10;j++)
                    {
                        creaCelda(j);
                    }
                }
                
                tbody.appendChild(fila);
            }
            
            tabla.appendChild(tbody);
            sectionPrin.appendChild(tabla);

            //BOTON TERMINAR
            boton = document.createElement("button");
            boton.addEventListener("click",function(){
                salir();
            })
            boton.innerText="TERMINAR";
            boton.classList.add("botones");
            sectionPrin.appendChild(boton);
            body.appendChild(sectionPrin);
        }
        preg = document.querySelectorAll("section.preguntaPrincipal");
        preg[0].classList.remove("ocultar");
    });
})
function creaCelda(j)
{
    celda = document.createElement("td");
    celda.innerText=j+1;
    celda.setAttribute("num",j);
    celda.addEventListener("click",function(){
        preg = document.querySelectorAll("section.preguntaPrincipal");
        for(q=0;q<preg.length;q++)
        {
            preg[q].classList.add("ocultar");
        }
        preg[this.getAttribute("num")].classList.remove("ocultar");
    })
    fila.appendChild(celda);
}

function salir(id_examen)
{
    preg = document.querySelectorAll("section.preguntaPrincipal > section");
    marcadas = [];
    for(i=0;i<preg.length;i++)
    {
        for(j=1;j<16;j=j+4)
        {
            if(preg[i].children[j].checked)
            {
                // console.log(preg[i].getAttribute("num"));
                switch(j)
                {
                    case 1:
                        pos = 1;
                        break;
                    case 5:
                        pos = j-3;
                        break;
                    case 9:
                        pos = j-6;
                        break;
                    case 13:
                        pos = j-9;
                        break;
                }
                //primero ver calificacion
                pregunta = new pregunta2(preg[i].getAttribute("id_preg"),preg[i].children[j].getAttribute("id_res"));
                marcadas[i]=pregunta;
            }
        }
    }
    marcadas=marcadas.filter(function (el) {
        return el != null;
      });
    console.log(marcadas);
    fetch("../../php/ajax/ajaxSaberCalificacionExamen?examen="+id_examen)
    .then(response => response.json())
    .then(data => {
        console.log(data);
    });
    //crear json con preguntas, respuestas e id examen
    
}