<?php
include("../bd/bd.php");
require "../cargadores/cargarEntidades.php";

BD::Conectar();
$clave="Cuando llueve, las ruedas del vehículo, ¿cómo se agarran a la calzada?";
// $vector = BD::selectPreguntaEnunciado($clave);
// var_dump($vector);
$a = json_encode(BD::selectExamenId(2));
var_dump($a);
var_dump(json_last_error_msg());

//SELECT respuestas.id as id_respuesta, respuestas.enunciado as enunciado_respuesta, tematica.id as id_tematica, tematica.tema, preguntas.id as id_pregunta, preguntas.enunciado as enunciado_pregunta, preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica FROM respuestas INNER JOIN preguntas on respuestas.id_pregunta = preguntas.id inner join tematica on tematica.id = preguntas.id_tematica