<?php
require "../cargadores/cargarSesion.php";
Sesion::abreSesion();
$indice = "editar".$_GET['tabla'];
unset($_SESSION[$indice]);