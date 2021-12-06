<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarEntidades.php";
require "../cargadores/cargarBD.php";
Sesion::abreSesion();
BD::Conectar();
$usuario = $_SESSION['usuario'];
$sol = new usuario($usuario->getId(),$usuario->getCorreo(),$usuario->getNombre(),$usuario->getApellidos(),$usuario->getPassword(),$usuario->getFecha_nac(),$usuario->getRol(),$usuario->getImagen());
$sol = BD::selectUsuarioEmail2($sol->getCorreo());
echo json_encode($sol->getImagen());
