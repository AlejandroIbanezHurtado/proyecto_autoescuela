<?php
require "../cargadores/cargarEntidades.php";
require "../cargadores/cargarBD.php";
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarHelper.php";

Sesion::abreSesion();
if(isset($_SESSION['usuario']))
{
    BD::Conectar();
    $usuario = BD::selectUsuarioEmail2($_SESSION['usuario']->getCorreo());
    echo json_encode($usuario->getRol());
}
else{
    echo json_encode("nada");
}