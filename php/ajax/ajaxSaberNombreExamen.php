<?php
require "../cargadores/cargarSesion.php";
Sesion::abreSesion();
$a = Sesion::miraSiExiste("nombreExamen");
echo json_encode($a);