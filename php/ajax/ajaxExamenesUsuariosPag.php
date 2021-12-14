<?php
require "../cargadores/cargarBD.php";
BD::Conectar();
if(isset($_GET['alumno']))
{
    $a = BD::obtenExamenesUsuariosPaginadosAlumno($_GET['pagina'], $_GET['filas'],$_GET['alumno']);
}
else{
    $a = BD::obtenExamenesUsuariosPaginados($_GET['pagina'], $_GET['filas']);
}

echo json_encode($a);