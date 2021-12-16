<?php
require "../cargadores/cargarEntidades.php";
require "../cargadores/cargarBD.php";
BD::Conectar();
if(isset($_POST['usuarios']))
{
    $usuarios = json_decode($_POST['usuarios']);
    BD::beginTransaction();
    $tran = true;
    for($i=0;$i<count($usuarios);$i++)
    {
        if(!(filter_var($usuarios[$i], FILTER_VALIDATE_EMAIL)))
        {
            $tran = false;
            break;
        }
    }
    if($tran)
    {
        for($i=0;$i<count($usuarios);$i++)
        {
            $u = new usuario(null, $usuarios[$i], "nombre", "apellidos", "abcd1234", "2021-01-01", "alumno", null, 1);
            BD::insertarUsuario($u);
        }
        BD::commit();
    }
    echo json_encode(BD::lastError()[1]);
    
}
else
{
    BD::beginTransaction();
    if(isset($_POST['preguntas']))
    {
        $preguntasCliente = json_decode($_POST['preguntas']);
        $preguntas = [];
        for($i=0;$i<count($preguntasCliente);$i++)
        {
            $preg = new pregunta($preguntasCliente[$i]->id, $preguntasCliente[$i]->enunciado, $preguntasCliente[$i]->id_respuesta_correcta, $preguntasCliente[$i]->recurso, $preguntasCliente[$i]->id_tematica, $preguntasCliente[$i]->vectorRespuestas);
            $preguntas[$i] = $preg;
        }
        for($i=0;$i<count($preguntas);$i++)
        {
            BD::insertarPregunta($preguntas[$i]);
            $id_pregunta = BD::selectPreguntaEnunciadoPeq($preguntas[$i]->getEnunciado());
            $preguntas[$i]->setId($id_pregunta);
            for($j=1;$j<count($preguntas[$i]->getVectorRespuestas());$j++)
            {
                $respuesta = new respuesta(null,$preguntas[$i]->getVectorRespuestas()[$j],$preguntas[$i]);
                BD::insertarRespuesta($respuesta);
            }
            $id_res = BD::selectRespuestaEnunciadoPeq($preguntas[$i]->getId_respuesta_correcta(), $preguntas[$i]->getId());
            BD::actualizaRespuestaCorrecta($id_res, $preguntas[$i]->getId());
        }
        BD::commit();
        echo json_encode(BD::lastError()[1]);
    }
}