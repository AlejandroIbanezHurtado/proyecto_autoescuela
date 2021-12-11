<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarBD.php";
Sesion::abreSesion();
BD::Conectar();
echo json_encode(BD::selectExamen());