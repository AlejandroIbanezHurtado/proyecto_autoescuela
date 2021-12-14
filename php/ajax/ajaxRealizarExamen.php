<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarBD.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
BD::Conectar();
if(isset($_GET['revisar']))
{
    Sesion::inserta("revisarExamen",$_GET['valor']);
    Sesion::inserta("examen",BD::selectExamenUsuarioId($_GET['valor'])[0]->getId());
    Sesion::inserta("duracion",BD::selectExamenUsuarioId($_GET['valor'])[0]->getDuracion());
    Sesion::inserta("nombreExamen",BD::selectExamenUsuarioId($_GET['valor'])[0]->getDescripcion());
    unset($_SESSION['realizaExamen']);
}
else{
    Sesion::inserta("realizaExamen",$_GET['valor']);
    Sesion::inserta("examen",BD::selectExamenId2($_GET['valor'])[0]->getId());
    Sesion::inserta("duracion",BD::selectExamenId2($_GET['valor'])[0]->getDuracion());
    Sesion::inserta("nombreExamen",BD::selectExamenId2($_GET['valor'])[0]->getDescripcion());
    unset($_SESSION['revisarExamen']);
}
