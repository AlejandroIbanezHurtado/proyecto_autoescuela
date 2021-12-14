<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
$a = Sesion::miraSiExiste("usuario");
echo json_encode($a->getCorreo());