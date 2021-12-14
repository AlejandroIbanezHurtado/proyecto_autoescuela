<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarBD.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
BD::Conectar();
if(Sesion::miraSiExiste("revisarExamen"))
{
    echo json_encode($_SESSION['revisarExamen']);
}else{
    echo json_encode(null);
}
