<?php
require "../cargadores/cargarBD.php";
require "../cargadores/cargarEntidades.php";
BD::Conectar();
$r = $_POST['res'];
$r = json_decode($r);
$cal = 0;
for($i=0;$i<count($r);$i++)
{
    $p = BD::selectPreguntaId($r[$i]->id_pregunta);
    
    if($p[$r[$i]->id_pregunta]->getId_respuesta_correcta()->getId()==$r[$i]->id_respuesta)
    {
        $cal++;
    }
}
echo $cal;
// var_dump($r[0]->id_pregunta);