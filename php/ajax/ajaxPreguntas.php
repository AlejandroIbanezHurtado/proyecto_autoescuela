<?php
require_once("../../php/bd/bd.php");
//require "../cargadores/cargarBD.php"; con cargadores
BD::Conectar();
$vector = BD::selectPregunta();
$vector = json_encode($vector);
echo $vector;