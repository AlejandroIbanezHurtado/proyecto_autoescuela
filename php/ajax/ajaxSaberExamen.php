<?php
require "../cargadores/cargarSesion.php";
Sesion::abreSesion();
$a = Sesion::miraSiExiste("examen");
echo json_encode($a);