<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarBD.php";
Sesion::abreSesion();
BD::Conectar();
Sesion::inserta("realizaExamen",$_GET['valor']);
Sesion::inserta("examen",BD::selectExamenId2($_GET['valor']));