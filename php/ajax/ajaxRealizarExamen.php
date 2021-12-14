<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarBD.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
BD::Conectar();
Sesion::inserta("realizaExamen",$_GET['valor']);
Sesion::inserta("examen",BD::selectExamenId2($_GET['valor'])[0]->getId());
Sesion::inserta("duracion",BD::selectExamenId2($_GET['valor'])[0]->getDuracion());
Sesion::inserta("nombreExamen",BD::selectExamenId2($_GET['valor'])[0]->getDescripcion());