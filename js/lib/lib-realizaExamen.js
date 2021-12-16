window.addEventListener("load",function(){
    var body = document.getElementsByTagName("body")[0];
    // var foto1 = document.getElementsByClassName("fotoAutoescuela")[0];
    // var historico = document.body.querySelector("a[href='../../js/paginas/historico.html']");
    // var examenPred = document.body.querySelector("a[href='../../js/paginas/listado_examenes.html']");
    // var examenAle = document.body.querySelector("a[href='###']");
    var contador = document.getElementById("contador");
    // var revisar = null;
    fetch("../../php/ajax/ajaxSaberRevisarExamen")
        .then(response => response.json())
        .then(re => {
            var revisar = re;
            console.log(revisar);

            fetch("../../php/ajax/ajaxSaberCorreoUsuario")
            .then(response => response.json())
            .then(data => {
                correoUsuario = data;
            });
        
            fetch("../../php/ajax/ajaxSaberNombreExamen")
            .then(response => response.json())
            .then(data => {
                nombreExamen = data;
            });
        
            fetch("../../php/ajax/ajaxSaberExamen")
            .then(response => response.json())
            .then(data => {
                examenS = data[0];
            });
            fetch("../../php/ajax/ajaxSaberDuracionExamen")
            .then(response => response.json())
            .then(data => {
                duracion = data;
                minutos = parseInt(duracion.substr(3,2));
                segundos = parseInt(duracion.substr(6,2));
                duracion2 = (minutos*60)+segundos;
                startTimer(duracion2, contador);
            });
        
            if(revisar!=null)
            {
                // data = "e";
                var h = null;
                fetch("../../php/ajax/ajaxDameExamen?id="+revisar)
                .then(response => response.json())
                .then(data => {
                    data = data[0];
                    data = JSON.parse(data);
        
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
                        enunciado.innerText = data[i].enunciado;
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
                            salir(examenS, contador.innerText, nombreExamen, numPreg, correoUsuario);
                        })
                        boton.innerText="TERMINAR";
                        boton.classList.add("botones");
                        sectionPrin.appendChild(boton);
                        body.appendChild(sectionPrin);
                        if(data[i].id_respuesta_correcta!=null)
                        {
                            z = data[i].id_respuesta_correcta.id;
                            console.log("section.preguntaPrincipal > section > input[id_res='"+z+"']");
                            res = document.querySelectorAll("section.preguntaPrincipal > section > input[id_res='"+z+"']");
                            res[0].checked=true;
                        }
                    }
                    preg = document.querySelectorAll("section.preguntaPrincipal");
                    preg[0].classList.remove("ocultar");
                });
            }
            else
            {
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
                            salir(examenS, contador.innerText, nombreExamen, numPreg, correoUsuario);
                        })
                        boton.innerText="TERMINAR";
                        boton.classList.add("botones");
                        sectionPrin.appendChild(boton);
                        body.appendChild(sectionPrin);
                    }
                    preg = document.querySelectorAll("section.preguntaPrincipal");
                    preg[0].classList.remove("ocultar");
                });
        
                this.setInterval(function(){
                    if(contador.innerText=="00:00")
                    {
                        salir(examenS, duracion, nombreExamen, numPreg, correoUsuario);
                        window.location.href="../../js/paginas/listado_examenes.html";
                    }
                }, 1000)
            }
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

function salir(id_examen, duracion, nombreExamen, numPreg, usuario)
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
                pregunta1 = new pregunta2(preg[i].getAttribute("id_preg"),preg[i].children[j].getAttribute("id_res"));
                marcadas[i]=pregunta1;
            }
        }
    }
    marcadas=marcadas.filter(function (el) {
        return el != null;
      });

    const data = new FormData();
    marcadas=JSON.stringify(marcadas);
    data.append("res",marcadas);
    fetch("../../php/ajax/ajaxSaberCalificacionExamen?examen="+id_examen, { method: 'POST', body: data })
    .then(function (response) {
        return response.text();
    })
    .then(function (body) {
        calificacion = body;
        examen1 = new examen(id_examen,nombreExamen,duracion,numPreg,1);
        
        preguntas = [];
        for(i=0;i<preg.length;i++)
        {
            respuestaCorrecta=null;
            respuestas = [];
            c=0;
            for(j=1;j<16;j=j+4)
            {
                c++;
                respuestaCopia = new respuesta(preg[i].children[j].getAttribute("id_res"),preg[i].children[j-1].innerText.substr(3));
                if(preg[i].children[j].checked)
                {
                    respuestaCorrecta = respuestaCopia;
                }
                respuestas[c] = respuestaCopia;
            }
            respuestas=respuestas.filter(function (el) {
                return el != null;
              });
            preguntaCopia = new pregunta(preg[i].getAttribute("id_preg"),preg[i].parentElement.children[0].innerText,respuestaCorrecta,preg[i].parentElement.children[1].src,null,respuestas);
            preguntas[i]=preguntaCopia;
        }
        console.log(preguntas);
        examenUsuario = new examen_usuario("",examen1,usuario,"",calificacion+"/"+numPreg,preguntas);
        const examenU = new FormData();
        examenUsuario = JSON.stringify(examenUsuario);
        examenU.append("examenUsuario",examenUsuario);
        fetch("../../php/ajax/ajaxInsertaExamenUsuario", { method: 'POST', body: examenU })
        .then(function (response) {
            return response.text();
        })
        window.location.href="../../js/paginas/historico.html";
    });
}

function startTimer(duracion, elemento) {
    var timer = duracion;
    var min;
    var seg;
    setInterval(function () {
        min = parseInt(timer / 60, 10);
        seg = parseInt(timer % 60, 10);

        min = min < 10 ? "0" + min : min;//concatenamos un cero cuando no sea 10 para que no queden solos
        seg = seg < 10 ? "0" + seg : seg;

        elemento.innerText = min + ":" + seg;

        if (--timer < 0) {
            timer = duracion;
        }
    }, 1000);
}