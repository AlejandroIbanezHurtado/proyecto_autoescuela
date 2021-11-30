<?php
require_once("../../php/bd/bd.php");
require "../cargadores/cargarEntidades.php";
//require "../cargadores/cargarBD.php"; con cargadores
BD::Conectar();
$examen = $_POST['examen'];
$preguntas = $_POST['preguntas'];
$preguntas = json_decode($preguntas);
$examen = json_decode($examen);
$descrip = BD::selectExamenDescripcion($examen->descripcion);
if($descrip==false && $examen->descripcion!="")
{
    if(preg_match("/^[0-2][0-3]:[1-5][0-9]$/",$examen->duracion))
    {
        $examen = new examen("", $examen->descripcion, $examen->duracion, $examen->num_preguntas, $examen->activo);
        BD::insertarExamen($examen);
        $id_examen = BD::selectExamenDescripcion($examen->getDescripcion());
        $examen = new examen($id_examen, $examen->getDescripcion(), $examen->getDuracion(), $examen->getNum_preguntas(), $examen->getActivo());
        for($i=0;$i<count($preguntas);$i++)
        {
            $id = $preguntas[$i];
            $pregunta = BD::selectPreguntaId($id);
            $examen_pregunta = new examen_pregunta($examen, $pregunta[$id]);
            var_dump(BD::insertarExamenPregunta($examen_pregunta));
        }
    }
    
}