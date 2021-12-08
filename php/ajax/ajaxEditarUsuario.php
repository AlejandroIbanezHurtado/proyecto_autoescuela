<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
Sesion::inserta("editar",$_SESSION['usuario']->getCorreo());
