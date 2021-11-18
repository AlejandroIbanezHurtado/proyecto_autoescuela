<?php
include("bd/bd.php");
BD::Conectar();
//var_dump(BD::borrarExamenPreguntaId_Examen("1"));
$vector = BD::selectExamenUsuario();
var_dump(json_decode($vector[1]->getEjecucion()));