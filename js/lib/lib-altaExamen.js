window.addEventListener("load",function(){
    const cajaDisponibles = document.getElementById("preguntasDisponibles");
    const cajaSeleccionadas = document.getElementById("preguntasSeleccionadas");
    const nPreg = document.getElementById("nPreg");
    const boton = document.getElementById("boton");
    var descripcion = document.getElementById("descripcion");
    var duracion = document.getElementById("duracion");

    fetch("../../php/ajax/ajaxPreguntas.php")
    .then(response => response.json())
    .then(data => {
        rellenaPreguntasDisponibles(data)
    });

    function rellenaPreguntasDisponibles(data){
        for (var i in data) {
            conPregunta = document.createElement("div");
            conPregunta.setAttribute("tipo","pregunta");
            tematica = document.createElement("div");
            tematica.setAttribute("class","tematica");
            pregunta = document.createElement("div");
            pregunta.innerText=data[i]['enunciado'];
            tematica.innerText=data[i].id_tematica.tema;
            conPregunta.setAttribute("id",data[i]['id']);
            conPregunta.addEventListener("click",function(){
                if(this.getAttribute("class")=="seleccionado")
                {
                    this.removeAttribute("class");
                }
                else{
                    this.setAttribute("class","seleccionado");
                }
            })
            conPregunta.draggable=true; 
            conPregunta.addEventListener("dragstart", function(e){ //cuando se empieza a arrastrar
                this.setAttribute("arrastrado","true");
                this.setAttribute("class","seleccionado");
            });
            conPregunta.addEventListener("dragend", function(){ //cuando se terminda de arrastrar
                this.removeAttribute("class");
            });
            conPregunta.appendChild(tematica);
            conPregunta.appendChild(pregunta);
            cajaDisponibles.appendChild(conPregunta);
            //cajaDisponibles.appendChild(pregunta);
        }


        cajaSeleccionadas.addEventListener("dragover",function(e){
            e.preventDefault();
        });

        //clase = cajaSeleccionadas.getAttribute("class");
        // cajaSeleccionadas.addEventListener("dragenter",function(e){
        //     e.preventDefault();
        //     this.setAttribute("class",clase+" dragEnter");
        // });
        
        // cajaSeleccionadas.addEventListener("dragleave",function(e){
        //     e.preventDefault();
        //     this.setAttribute("class",clase);
        // });
        cajaSeleccionadas.addEventListener("drop",function(e){
            e.preventDefault();
            seleccionadas = document.getElementsByClassName("seleccionado");
            for(i=0;i<seleccionadas.length;i++)
            {
                this.appendChild(seleccionadas[0]);
            }
            preguntas = document.querySelectorAll('#preguntasSeleccionadas > div[tipo=pregunta]');
            nPreg.innerText="Nº preguntas: "+preguntas.length;
        })

        cajaDisponibles.addEventListener("dragover",function(e){
            e.preventDefault();
        });
        cajaDisponibles.addEventListener("drop",function(e){
            e.preventDefault();
            seleccionadas = document.getElementsByClassName("seleccionado");
            for(i=0;i<seleccionadas.length;i++)
            {
                this.appendChild(seleccionadas[0]);
            }
            preguntas = document.querySelectorAll('#preguntasSeleccionadas > div[tipo=pregunta]');
            nPreg.innerText="Nº preguntas: "+preguntas.length;
        })

        boton.addEventListener("click", function(e){
            e.preventDefault();
            preguntas = document.querySelectorAll('#preguntasSeleccionadas > div[tipo=pregunta]');
            if(preguntas.length<5)
            {
                alert("Seleccione almenos 5 preguntas");
            }
            else{
                //crear objeto examen y enviarlo por ajax para que se guarde en la bd
                // alert(descripcion.value);
                const ajax = new XMLHttpRequest();
                ajax.onreadystatechange=function(){
                    if(ajax.readyState==4 && ajax.status==200)
                    {
                        var respuesta = ajax.responseText;
                        if(respuesta!="")
                        {
                            alert("Ya hay un examen con este nombre");
                        }
                        else{
                            if(/^[0-2][0-3]:[1-5][0-9]$/.test(duracion.value))
                            {
                                preguntas = document.querySelectorAll('#preguntasSeleccionadas > div[tipo=pregunta]');
                                vector=[];
                                for(i=0;i<preguntas.length;i++)
                                {
                                    vector[i] = preguntas[i].id;
                                }
                                const data = new FormData();
                                vector = JSON.stringify(vector);
                                data.append("preguntas",vector);
                                examen = new examen("",descripcion.value,duracion.value,preguntas.length,true);
                                examen = JSON.stringify(examen);
                                data.append("examen",examen);
                                fetch('../../php/ajax/ajaxInsertaExamen.php', { method: 'POST', body: data })
                                .then(function (response) {
                                    return response.text();
                                })
                                .then(function (body) {
                                    console.log(body);
                                });
                            }
                            else{
                                alert("La duración mínima es de 10 minutos");
                            }
                            
                        }
                    }
                }
                ajax.open("GET","../../php/ajax/ajaxExisteExamen.php?examen="+descripcion.value);
                ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                ajax.send();
                
                
                
                // exam = new examen("", descripcion, duracion, num_preguntas, activo)
            }
        })

    }
    
})