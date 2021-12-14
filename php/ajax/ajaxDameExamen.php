<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarBD.php";
Sesion::abreSesion();
BD::Conectar();
if(isset($_GET['id']))
{
    echo json_encode(BD::selectEjecucionExamenUsuario($_GET['id']));
}
else{
    echo json_encode(BD::selectExamenId(Sesion::miraSiExiste('realizaExamen')));
}