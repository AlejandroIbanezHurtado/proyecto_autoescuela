<?php
require "../cargadores/cargarSesion.php";
Sesion::abreSesion();
$a = Sesion::miraSiExiste("duracion");
echo json_encode($a);