<?php
require_once("../../php/bd/bd.php");
//require "../cargadores/cargarBD.php"; con cargadores
BD::Conectar();
if(isset($_GET['examen']))
{
    $vector = BD::selectExamenDescripcion($_GET['examen']);
    if($vector!=false)
    {
        $vector = json_encode($vector);   
    }
    echo $vector;
}
