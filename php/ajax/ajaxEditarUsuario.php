<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
Sesion::inserta("editarUsuario",$_SESSION['usuario']->getCorreo());
