window.addEventListener("load",function(){
    const cajaDisponibles = document.getElementById("preguntasDisponibles");
    const cajaSeleccionadas = document.getElementById("preguntasSeleccionadas");
    const nPreg = document.getElementById("nPreg");
    const boton = document.getElementById("boton");
    var descripcion = document.getElementById("descripcion");
    var duracion = document.getElementById("duracion");
    var buscaDisponibles = document.getElementById("buscaDisponibles");
    var buscaSeleccioandas = document.getElementById("buscaSeleccionadas");

    fetch("../../php/ajax/ajaxSesion.php")
    .then(response => response.json())
    .then(data => {
        cargaPagina(data);
    });

    function cargaPagina(data)
    {
        switch(data)
        {
            case "alumno":
                window.location.href = "../../php/paginas/login.php";
                break;
            case "administrador":
                fetch("../../php/ajax/ajaxPreguntas.php")
                .then(response => response.json())
                .then(data => {
                    rellenaPreguntasDisponibles(data);
                });
                break;
            case "nada":
                window.location.href = "../../php/paginas/login.php";
                break;
        }
    }

    buscaDisponibles.addEventListener("keyup",function(){
        buscaPor("preguntasDisponibles", buscaDisponibles.value);
    })
    buscaSeleccioandas.addEventListener("keyup",function(){
        buscaPor("preguntasSeleccionadas", buscaSeleccioandas.value);
    })

    function buscaPor(id, texto)
    {
        preguntas = document.querySelectorAll("#"+id+" > div[tipo=pregunta]");
        for(i=0;i<preguntas.length;i++)
        {
            if(preguntas[i].children[1].innerText.indexOf(texto)==-1)
            {
                preguntas[i].classList.add("ocultar");
            }
            else{
                preguntas[i].classList.remove("ocultar");
            }
            
        }
    }

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
                this.classList.toggle("seleccionado");
            })
            conPregunta.draggable=true; 
            conPregunta.addEventListener("dragstart", function(e){ //cuando se empieza a arrastrar
                this.classList.add("seleccionado");
            });
            conPregunta.addEventListener("dragend", function(){ //cuando se terminda de arrastrar
                this.classList.remove("seleccionado");
            });
            conPregunta.appendChild(tematica);
            conPregunta.appendChild(pregunta);
            cajaDisponibles.appendChild(conPregunta);
        }

        function quitaColor(vector)
        {
            for(i=0;i<vector.length;i++)
            {
                vector[i].classList.remove("seleccionado");
            }
        }

        cajaSeleccionadas.addEventListener("dragover",function(e){
            e.preventDefault();
        });

        cajaSeleccionadas.addEventListener("drop",function(e){
            e.preventDefault();
            seleccionadas = document.getElementsByClassName("seleccionado");
            for(i=0;i<seleccionadas.length;i++)
            {
                this.appendChild(seleccionadas[0]);
            }
            var p = document.querySelectorAll("#preguntasSeleccionadas .seleccionado");
            quitaColor(p);
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
                this.appendChild(seleccionadas[i]);
            }
            var p = document.querySelectorAll("#preguntasDisponibles .seleccionado");
            quitaColor(p);
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
                                window.location.href=reload();
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